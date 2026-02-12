<?php

/**
 * Controlador: Login Público
 *
 * Este controlador gestiona el inicio de sesión desde la página pública de la aplicación.
 *
 * Funcionalidad:
 * - Gestiona la navegación:
 *      - Botón "Atrás" redirige a `inicioPublico`.
 *      - Botón "Registro" redirige a la página de registro.
 * - Valida los datos del formulario de login:
 *      - `codUsuario` (alfanumérico, 4-10 caracteres)
 *      - `password` (alfanumérico, 4-10 caracteres, al menos 1 carácter especial)
 * - Si las credenciales son correctas:
 *      - Carga el usuario en sesión (`usuarioActualDWESAplicacionFinal`).
 *      - Genera un token API único si no existe y lo guarda en la base de datos.
 *      - Redirige a la página de inicio privado (`inicioPrivado`).
 * - Si las credenciales son incorrectas, muestra errores en el formulario.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Clase `validacionFormularios`
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

// Botón "Atrás" a inicio público
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

// Botón "Registro" redirige a registro
if (isset($_REQUEST['registro'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'Registro';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'codUsuario' => null,
    'password' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => ''
];

$entradaOK = true;

// Procesamiento del formulario de login
if (isset($_REQUEST['acceder'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $codUsuario = $_REQUEST['codUsuario'] ?? '';
    $passwordPlain = $_REQUEST['password'] ?? '';

    // Validaciones
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico($codUsuario, 10, 4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($passwordPlain, 10, 4, 1, 1);

    // Guardar respuestas
    $aRespuestas['codUsuario'] = $codUsuario;
    $aRespuestas['password'] = $passwordPlain;

    // Comprobar si hay errores
    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $passwordCombinado = $codUsuario . $passwordPlain;

        $usuarioPDO = new UsuarioPDO();
        $usuario = $usuarioPDO->validarUsuario($codUsuario, $passwordCombinado);

        if ($usuario) {
            // Guardar usuario en sesión
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuario;

            // Obtener o generar token API
            $token = $usuarioPDO->obtenerToken($codUsuario);
            if (!$token) {
                $token = bin2hex(random_bytes(32));
                $usuarioPDO->guardarToken($codUsuario, $token);
            }

            $_SESSION['tokenAPI'] = $token;

            // Redirigir a inicio privado
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
            $aErrores['codUsuario'] = 'Usuario o contraseña incorrecta';
            $entradaOK = false;
        }
    }

} else {
    $entradaOK = false;
}

// Cargar layout con el formulario y errores
require_once $view['layout'];
