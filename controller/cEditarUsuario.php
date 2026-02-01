<?php
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'MtoUsuarios';
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

$usuarioPDO = new usuarioPDO();
$codUsuario = $_SESSION['codUsuarioSeleccionado'];

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
        $_SESSION['paginaEnCurso'] = 'MtoUsuarios';
        header('Location: index.php');
        exit;
    }
} elseif (isset($_REQUEST['confirmar'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['passwordactual'] = validacionFormularios::validarPassword(
        $_REQUEST['passwordactual'],
        10,
        4,
        1,
        1
    );

    $aErrores['passwordnueva'] = validacionFormularios::validarPassword(
        $_REQUEST['passwordnueva'],
        10,
        4,
        1,
        1
    );

    $aRespuestas['passwordactual'] = $_REQUEST['passwordactual'];
    $aRespuestas['passwordnueva'] = $_REQUEST['passwordnueva'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if (
        $entradaOK &&
        hash('sha256', $codUsuario . $_REQUEST['passwordactual']) === $_SESSION['usuarioSeleccionado']->T01_Password
    ) {
        $usuarioPDO->cambiarPassword($codUsuario, $_REQUEST['passwordnueva']);
        $_SESSION['paginaEnCurso'] = 'MtoUsuarios';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
