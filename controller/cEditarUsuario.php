<?php
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
