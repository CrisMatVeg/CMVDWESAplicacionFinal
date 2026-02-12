<?php
/**
 * Controlador: WIP
 *
 * Este controlador gestiona la página WIP (Work In Progress) de la aplicación.
 * Su función principal es permitir la navegación hacia otra página si se envía
 * `paginaDestino`, o retroceder si se pulsa "Atrás".
 *
 * Funcionalidad:
 * - Botón "Atrás": vuelve a la página anterior almacenada en sesión.
 * - Navegación a otra página: si se envía `paginaDestino`, actualiza la página
 *   anterior y la página en curso y redirige.
 * - Si no hay acción, simplemente carga el layout principal.
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar la vista layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

// Botón Atrás
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Navegación a otra página
if (isset($_REQUEST['paginaDestino'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = $_REQUEST["paginaDestino"];
    header('Location: index.php');
    exit;
}

// Cargar layout principal
require_once $view["layout"];
