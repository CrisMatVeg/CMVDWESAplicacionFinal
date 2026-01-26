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

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$claveApiNasa = 'aJQGMfgeU4awVVTZeZeGMd5f6584nCyFtm4Ud4h1';
$nasa = new NASA($claveApiNasa);
$dogapi = new DogApi();
$listadoRazas= $dogapi->obtenerRazas();

if (isset($_REQUEST['enviarRaza'])) {
    $_SESSION['razaPerroSeleccionada']=$_REQUEST['razas'];
}
if (isset($_REQUEST['enviarFecha'])) { //validar fecha con libreria
    $_SESSION['fechaFotoNasa']=$_REQUEST['fecha'];
}
$_SESSION['fotoDelDia'] = $nasa->obtenerFotoDelDia($_SESSION['fechaFotoNasa']);
$fotoPerro = $dogapi->obtenerPerro($_SESSION['razaPerroSeleccionada']);

require_once $view["layout"];
