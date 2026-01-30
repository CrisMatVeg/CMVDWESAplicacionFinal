<?php
if (!isset($_SESSION['usuarioActualDWESLoginLogoff'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$departamentoPDO = new DepartamentoPDO();

if (isset($_REQUEST['confirmar']) && $_REQUEST['confirmacion']==="SI") {
    $codUsuario = $_SESSION['codDptoSeleccionado'];
    $departamentoPDO->borrarDepartamento($codUsuario);
    $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
    header('Location: index.php');
    exit;
}
require_once $view["layout"];