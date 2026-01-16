<?php
/**
 * Controlador: Detalle (cDetalle)
 *
 * Este controlador gestiona la navegación de la página de detalle
 * en la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * 1. Gestión del botón "Atrás":
 *    - Si se envía `atras`, actualiza las variables de sesión:
 *       - `paginaAnterior` con el valor enviado
 *       - `paginaEnCurso` con la página anterior
 *    - Redirige inmediatamente a `indexLoginLogoff.php`.
 *
 * 2. Si no se envía `atras`, carga la vista principal (`layout`).
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar la vista layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

if (!isset($_SESSION['usuarioActualDWESLoginLogoff'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}

// Carga la vista layout principal
require_once $view["layout"];
