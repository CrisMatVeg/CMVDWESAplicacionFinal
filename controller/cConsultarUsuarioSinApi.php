<?php
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
    header('Location: index.php');
    exit;
}
if (!isset($_SESSION['usuarioSeleccionado'])) {
    $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
    header('Location: index.php');
    exit;
}
$avConsultarUsuario = [
    "codUsuario" => $_SESSION['usuarioSeleccionado']->getCodUsuario(),
    "numConexiones" => $_SESSION['usuarioSeleccionado']->getNumConexiones(),
    "fechaHoraUltimaConexion" => $_SESSION['usuarioSeleccionado']->getFechaHoraUltimaConexion(),
    "descUsuario" => $_SESSION['usuarioSeleccionado']->getDescUsuario(),
    "perfil"=>$_SESSION['usuarioSeleccionado']->getPerfil()
];
require_once $view["layout"];