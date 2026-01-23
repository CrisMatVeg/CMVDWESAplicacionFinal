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
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
/* if (isset($_REQUEST['enviar'])) {
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 0);
    if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $_REQUEST['descripcion'])) {
        $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
    }
    foreach ($aErrores as $campo => $valor) {
        if ($valor != null) { // Si ha habido algun error $entradaOK es falso.
            $entradaOK = false;
        }
    }
} else {
    // Formulario no enviado aún
    $entradaOK = false;
} */
// Llamar al modelo
$departamentoPDO = new DepartamentoPDO();
$departamentos = $departamentoPDO->buscarDepartamentos();
require_once $view["layout"];