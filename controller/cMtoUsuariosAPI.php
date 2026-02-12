<?php
/**
 * Controlador: Mantenimiento de Usuarios API
 *
 * Este controlador gestiona la navegación de la página de mantenimiento de usuarios
 * de tipo API en la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Valida sesión: si no hay usuario activo, redirige a Login.
 * - Navegación entre páginas:
 *      - Atrás: vuelve a la página anterior, reinicia sesión.
 *      - Volver: vuelve a la página anterior.
 * - Carga la vista principal (`layout`).
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`.
 * - Arreglo `$view` para cargar la vista layout.
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

// Validación de sesión
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Botón Atrás: reinicia sesión y vuelve a la página anterior
if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Botón Volver: vuelve a la página anterior
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Cargar vista principal
require_once $view["layout"];
