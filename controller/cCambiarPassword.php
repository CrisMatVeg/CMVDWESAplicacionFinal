<?php
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
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'passwordactual' => null,
    'passwordnueva' => null
];

$aRespuestas = [
    'passwordactual' => '',
    'passwordnueva' => ''
];

$entradaOK = true;

$usuarioPDO = new UsuarioPDO();

if (isset($_REQUEST['confirmar'])) {

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
        hash(
            'sha256',
            $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario() . $_REQUEST['passwordactual']
        ) === $_SESSION['usuarioActualDWESAplicacionFinal']->getPassword()
    ) {
        $usuarioPDO->cambiarPassword(
            $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario(),
            $_REQUEST['passwordnueva']
        );
        $_SESSION['paginaEnCurso'] = 'MiCuenta';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
