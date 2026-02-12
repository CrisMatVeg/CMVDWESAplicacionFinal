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
$avConsultarDpto = [
    "codDepartamento" => $_SESSION['dptoSeleccionado']->getCodDepartamento(),
    "descDepartamento" => $_SESSION['dptoSeleccionado']->getDescDepartamento(),
    "fechaCreacionDepartamento" => $_SESSION['dptoSeleccionado']->getFechaCreacionDepartamento(),
    "VolumenDeNegocio" => $_SESSION['dptoSeleccionado']->getVolumenDeNegocio(),
    "fechaBajaDepartamento"=>$_SESSION['dptoSeleccionado']->getFechaBajaDepartamento()
];
require_once $view["layout"];