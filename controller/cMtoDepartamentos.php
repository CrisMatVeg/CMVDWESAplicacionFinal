<?php
if (!isset($_SESSION['usuarioActualDWESLoginLogoff'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

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
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['verDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editarDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: index.php');
    exit;
}

$entradaOK = true;
$aErrores = [
    'descripcion' => '',
];
$aRespuestas = [
    'descripcion' => '',
];

$departamentoPDO = new DepartamentoPDO();

// Si ya hay búsqueda previa guardada en sesión, rellenamos $aRespuestas
if (isset($_SESSION['busquedaDepartamento'])) {
    $aRespuestas['descripcion'] = $_SESSION['busquedaDepartamento'];
}

if (isset($_REQUEST['enviar'])) {
    // Validamos el campo
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 0);
    if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $_REQUEST['descripcion'])) {
        $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
    }

    // Comprobamos si hubo errores
    foreach ($aErrores as $campo => $valor) {
        if ($valor != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Guardamos en sesión
        $_SESSION['busquedaDepartamento'] = $_REQUEST['descripcion'];
    }
}

// Llamar al modelo
if ($entradaOK && !empty($_SESSION['busquedaDepartamento'])) {
    $departamentos = $departamentoPDO->buscarDepartamentos($_SESSION['busquedaDepartamento']);
} else {
    $departamentos = $departamentoPDO->buscarDepartamentos();
}

require_once $view["layout"];
