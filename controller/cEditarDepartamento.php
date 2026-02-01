<?php
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'descDepartamento' => null,
    'VolumenDeNegocio' => null
];

$aRespuestas = [
    'descDepartamento' => '',
    'VolumenDeNegocio' => ''
];

$entradaOK = true;

$departamentoPDO = new DepartamentoPDO();

if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['descDepartamento'],
        255,
        1,
        1
    );

    $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat(
        $_REQUEST['VolumenDeNegocio'],
        PHP_FLOAT_MAX,
        0,
        1
    );

    $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
    $aRespuestas['VolumenDeNegocio'] = $_REQUEST['VolumenDeNegocio'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $codUsuario = $_SESSION['codDptoSeleccionado'];
        $datosNuevos = [
            "T02_DescDepartamento" => $_REQUEST['descDepartamento'],
            "T02_VolumenDeNegocio" => $_REQUEST['VolumenDeNegocio']
        ];
        $departamentoPDO->editarDepartamento($codUsuario, $datosNuevos);
        $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
