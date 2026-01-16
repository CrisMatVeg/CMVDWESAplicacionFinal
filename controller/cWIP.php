<?php
/**
 * Controlador: Inicio Público (cInicioPublico)
 *
 * Este controlador gestiona la navegación desde la página de inicio público
 * de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Verifica si se ha enviado `paginaDestino` mediante formulario o enlace.
 * - Si se ha enviado:
 *      - Actualiza la página anterior (`paginaAnterior`) con la página en curso.
 *      - Actualiza la página en curso (`paginaEnCurso`) con el destino.
 *      - Redirige inmediatamente a `indexLoginLogoff.php` para cargar la vista correspondiente.
 * - Si no se ha enviado `paginaDestino`, carga la vista principal (`layout`).
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar la vista layout principal
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}
if (isset($_REQUEST['paginaDestino'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = $_REQUEST["paginaDestino"];
    header('Location: indexLoginLogoff.php');
    exit;
}

// Carga la vista layout principal
require_once $view["layout"];
