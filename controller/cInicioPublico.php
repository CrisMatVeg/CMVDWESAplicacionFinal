<?php
/**
 * Controlador: Inicio Público
 *
 * Este controlador gestiona la navegación desde la página de inicio público
 * de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Comprueba si se ha enviado `paginaDestino` mediante formulario o enlace.
 * - Si se ha enviado:
 *      - Actualiza `paginaAnterior` con la página en curso.
 *      - Actualiza `paginaEnCurso` con el destino.
 *      - Redirige a `index.php` para cargar la vista correspondiente.
 * - Si no se ha enviado `paginaDestino`, carga la vista principal (`layout`).
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar la vista layout principal
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

if (isset($_REQUEST['paginaDestino'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = $_REQUEST["paginaDestino"];
    header('Location: index.php');
    exit;
}

// Carga la vista layout principal
require_once $view["layout"];
