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
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    /* UsuarioPDO::guardarToken($codUsuario, null); */
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

$aErrores = [
    'description' => null
];

$aRespuestas = [
    'description' => ''
];

$entradaOK = true;

$usuarioPDO = new usuarioPDO();
$codUsuario = $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario();

if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['description'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['description'],
        255,
        1,
        1
    );

    $aRespuestas['description'] = $_REQUEST['description'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $datosNuevos = [
            "T01_DescUsuario" => $_REQUEST['description']
        ];

        $usuarioPDO->editarUsuario($codUsuario, $datosNuevos);
        $usuario = $usuarioPDO->validarUsuario($codUsuario, null);

        if ($usuario != false) {
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuario;

            $avMiPerfil = [
                "codUsuario" => $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario(),
                "numConexiones" => $_SESSION['usuarioActualDWESAplicacionFinal']->getNumConexiones(),
                "fechaHoraUltimaConexionAnterior" => $_SESSION['usuarioActualDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior(),
                "descUsuario" => $_SESSION['usuarioActualDWESAplicacionFinal']->getDescUsuario(),
                "esAdmin"=>$esAdmin
            ];

            $_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal'] = $avMiPerfil;
            header('Location: index.php');
            exit;
        }
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
