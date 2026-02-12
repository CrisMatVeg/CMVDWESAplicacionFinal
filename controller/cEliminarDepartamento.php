<?php
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'confirmacion' => null
];

$aRespuestas = [
    'confirmacion' => ''
];

$entradaOK = true;

$departamentoPDO = new DepartamentoPDO();

if (isset($_REQUEST['confirmar'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['confirmacion'] = $_REQUEST['confirmacion'] === "SI"
        ? null
        : "Confirmación incorrecta";

    $aRespuestas['confirmacion'] = $_REQUEST['confirmacion'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $codUsuario = $_SESSION['codDptoSeleccionado'];
        $departamentoPDO->borrarDepartamento($codUsuario);
        $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
