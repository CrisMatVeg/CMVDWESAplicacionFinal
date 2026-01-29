<?php
if (!isset($_SESSION['usuarioActualDWESLoginLogoff'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['fechaFotoNasa'])) {
    $fechaActual = new DateTime();
    $fechaFormateada = $fechaActual->format('Y-m-d');
    $_SESSION['fechaFotoNasa']=$fechaFormateada;
}

if (!isset($_SESSION['razaPerroSeleccionada'])) {
    $_SESSION['razaPerroSeleccionada']=null;
}

if (isset($_REQUEST['ampliarnasa'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'DetallesNasa';
    header('Location: index.php');
    exit;
}
if (isset($_REQUEST['ampliardog'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'DetallesDog';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

/* ===== PROCESAR FORMULARIOS ===== */
if (isset($_REQUEST['enviarFecha']) && !empty($_REQUEST['fecha'])) {
    $_SESSION['fechaFotoNasa'] = $_REQUEST['fecha'];
}

if (isset($_REQUEST['enviarRaza'])) {
    $_SESSION['razaPerroSeleccionada'] = $_REQUEST['razas'] ?: null;
}

$rest = new REST();

$claveApiNasa = 'aJQGMfgeU4awVVTZeZeGMd5f6584nCyFtm4Ud4h1';

/* ===== NASA ===== */
$datosNasaApi = $rest->obtenerNasa($claveApiNasa, $_SESSION['fechaFotoNasa']);
$nasa = $datosNasaApi ? new NASA($datosNasaApi) : null;

/* ===== DOG ===== */
$datosPerroApi = $rest->obtenerPerro($_SESSION['razaPerroSeleccionada']);
$perro = $datosPerroApi ? new DogApi($datosPerroApi) : null;

/* ===== RAZAS ===== */
$datosRazasApi = $rest->obtenerRazasPerro();
$listadoRazas = DogApi::procesarRazas($datosRazasApi);

/* ===== ARRAY ÚNICO PARA LA VISTA ===== */
$_SESSION['nasa'] = $nasa->obtenerDatosFotoNasa();
$_SESSION['perro'] = $perro->obtenerDatosFotoPerro();
$_SESSION['razas'] = $listadoRazas;

require_once $view["layout"];
