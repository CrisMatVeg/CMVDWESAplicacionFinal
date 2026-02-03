<?php
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
$usuarioPDO = new UsuarioPDO();
$usuarioSeleccionado= $usuarioPDO->seleccionarUsuario($_SESSION['codUsuarioSeleccionado']);
$_SESSION['usuarioSeleccionado'] = $usuarioSeleccionado;
require_once $view["layout"];