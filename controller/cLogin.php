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
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

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

if (isset($_REQUEST['acceder'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validaciones usando la librería
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['codUsuario'],
        10,
        4,
        1
    );

    $aErrores['password'] = validacionFormularios::validarPassword(
        $_REQUEST['password'],
        10,
        4,
        1,
        1
    );

    // Guardar respuestas
    $aRespuestas['codUsuario'] = $_REQUEST['codUsuario'];
    $aRespuestas['password'] = $_REQUEST['password'];

    // Comprobar si hay errores
    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {

        $codUsuario = $_REQUEST['codUsuario'];
        $password = $codUsuario . $_REQUEST['password'];

        // Llamar al modelo
        $usuarioPDO = new UsuarioPDO();
        $usuario = UsuarioPDO::validarUsuario($codUsuario, $password);

        if ($usuario) {
            // Guardar usuario en sesión para la app
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuario;
        
            // Buscar si ya tiene token en la base de datos
            $token = UsuarioPDO::obtenerToken($codUsuario);
        
            if (!$token) {
                // Generar token aleatorio (una sola vez)
                $token = bin2hex(random_bytes(32)); // 64 caracteres hex
                UsuarioPDO::guardarToken($codUsuario, $token);
            }
        
            // Guardar token en sesión opcional (para mostrarlo en la app)
            $_SESSION['tokenAPI'] = $token;
        
            // Redirigir a la app
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        } else {
            // Usuario o contraseña incorrecta
            $aErrores['codUsuario'] = 'Usuario o contraseña incorrecta';
            $entradaOK = false;
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}

require_once $view['layout'];
