<?php

/**
 * Controlador: Mi Perfil
 *
 * Este controlador gestiona la edición de los datos del usuario actual en la aplicación.
 *
 * Funcionalidad:
 * - Valida sesión activa del usuario.
 * - Gestiona navegación:
 *      - Botón "Atrás": destruye sesión y vuelve a la página anterior.
 *      - Botón "Volver": vuelve al inicio privado.
 *      - Botón "Borrar cuenta": redirige a la página de eliminación de cuenta.
 *      - Botón "Cambiar contraseña": redirige a la página de cambio de password.
 * - Procesa formulario de edición de descripción del usuario:
 *      - Valida el campo `description` como alfanumérico.
 *      - Si es correcto, actualiza el usuario en la base de datos y en sesión.
 *      - Actualiza array de datos del usuario (`$datosUsuarioVista`) para la vista.
 *
 * Dependencias:
 * - Clase `UsuarioPDO` y métodos `editarUsuario` y `validarUsuario`
 * - Clase `validacionFormularios`
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar la vista layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

// Control de sesión
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Navegación
if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarCuenta'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'BorrarCuenta';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['cambiarContraseña'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'CambiarPassword';
    header('Location: index.php');
    exit;
}

// Inicialización de errores y respuestas
$aErrores = ['description' => null];
$aRespuestas = ['description' => ''];
$entradaOK = true;

$usuarioPDO = new UsuarioPDO();
$codUsuario = $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario();

// Procesamiento del formulario de edición de descripción
if (isset($_REQUEST['cambiarDatos'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $descripcion = $_REQUEST['description'] ?? '';
    $aErrores['description'] = validacionFormularios::comprobarAlfaNumerico($descripcion, 255, 1, 1);
    $aRespuestas['description'] = $descripcion;

    // Comprobar errores
    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Actualizar usuario
        $datosNuevos = ["T01_DescUsuario" => $descripcion];
        $usuarioPDO->editarUsuario($codUsuario, $datosNuevos);

        $usuarioActualizado = $usuarioPDO->validarUsuario($codUsuario, null);
        if ($usuarioActualizado !== false) {
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuarioActualizado;

            // Preparar datos del usuario para la vista
            $datosUsuarioVista = [
                "codUsuario" => $usuarioActualizado->getCodUsuario(),
                "numConexiones" => $usuarioActualizado->getNumConexiones(),
                "fechaHoraUltimaConexionAnterior" => $usuarioActualizado->getFechaHoraUltimaConexionAnterior(),
                "descUsuario" => $usuarioActualizado->getDescUsuario(),
                "esAdmin" => $usuarioActualizado->getPerfil() === "admin"
            ];

            $_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal'] = $datosUsuarioVista;
            header('Location: index.php');
            exit;
        }
    }
} else {
    $entradaOK = false;
}

// Carga la vista principal
require_once $view["layout"];
