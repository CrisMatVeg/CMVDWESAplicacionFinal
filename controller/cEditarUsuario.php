<?php
/**
 * Controlador: Modificación de Usuario API
 *
 * Este controlador gestiona la visualización y edición de un usuario
 * previamente seleccionado en el mantenimiento de usuarios API.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Permite volver a la página de mantenimiento de usuarios mediante "Atrás".
 * - Obtiene el usuario seleccionado desde sesión y base de datos.
 * - Prepara los datos del usuario para la vista.
 * - Valida los campos del formulario al intentar cambiar datos:
 *      - DescUsuario (alfanumérico, 1-255 caracteres)
 *      - Perfil (alfanumérico, 1-10 caracteres)
 * - Si la validación es correcta, actualiza el usuario mediante
 *   `UsuarioPDO::editarUsuario` y redirige al mantenimiento.
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
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'DescUsuario' => null,
    'Perfil' => null,
    'passwordactual' => null,
    'passwordnueva' => null
];

$aRespuestas = [
    'DescUsuario' => '',
    'Perfil' => '',
    'passwordactual' => '',
    'passwordnueva' => ''
];

$entradaOK = true;

$usuarioPDO = new UsuarioPDO();
$codUsuario = $_SESSION['codUsuarioSeleccionado'];
$usuarioSeleccionado= $usuarioPDO->validarUsuario($_SESSION['codUsuarioSeleccionado']);
$_SESSION['usuarioSeleccionado'] = $usuarioSeleccionado;

if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['DescUsuario'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['DescUsuario'],
        255,
        1,
        1
    );

    $aErrores['Perfil'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['Perfil'],
        10,
        1,
        1
    );

    $aRespuestas['DescUsuario'] = $_REQUEST['DescUsuario'];
    $aRespuestas['Perfil'] = $_REQUEST['Perfil'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $datosNuevos = [
            "T01_DescUsuario" => $_REQUEST['DescUsuario'],
            "T01_Perfil" => $_REQUEST['Perfil']
        ];
        $usuarioPDO->editarUsuario($codUsuario, $datosNuevos);
        $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
        header('Location: index.php');
        exit;
    }
} else{
    $entradaOK=false;
}

require_once $view["layout"];
