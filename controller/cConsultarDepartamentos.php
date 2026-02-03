<?php
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
$departamentoPDO = new DepartamentoPDO();
$codDpto = $_SESSION['codDptoSeleccionado'];
$dptoSeleccionado = $departamentoPDO->seleccionarDepartamento($codDpto);
$_SESSION['dptoSeleccionado'] = $dptoSeleccionado;
require_once $view["layout"];