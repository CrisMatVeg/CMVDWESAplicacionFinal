<?php
/**
 * Controlador: Consultar Usuario API (actualmente no activo, se utiliza la API de wsConsultarUsuario)
 *
 * Este controlador permite visualizar los datos de un usuario
 * previamente seleccionado en el mantenimiento de usuarios.
 *
 * Funcionalidad:
 * - Permite volver a la página de mantenimiento de usuarios.
 * - Verifica que exista un usuario seleccionado en sesión.
 * - Prepara un array asociativo con los datos del usuario
 *   para su visualización en la vista.
 *
 * Dependencias:
 * - Objeto Usuario almacenado en sesión (`usuarioSeleccionado`)
 * - Clase Usuario y sus métodos getter
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

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