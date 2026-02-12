<?php
/**
 * Controlador: Detalle de usuario
 *
 * Este controlador gestiona la navegación de la página de detalle
 * en la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Gestión del botón "Atrás":
 *      - Actualiza `paginaAnterior` y `paginaEnCurso` según la sesión.
 *      - Redirige a `index.php`.
 * - Si no se envía "atras", carga la vista principal (`layout`).
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @version 2.0
 */

if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Carga la vista layout principal
require_once $view["layout"];
