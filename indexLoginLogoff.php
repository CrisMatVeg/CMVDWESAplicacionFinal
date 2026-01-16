<?php
require_once ("./config/confAPP.php");
require_once ("./config/confDBPDO.php");

/**
 * Inicializa la sesión y establece la página por defecto
 *
 * Este script sirve como punto de entrada de la aplicación. 
 * Se encarga de iniciar la sesión, establecer la página por defecto 
 * en caso de que no exista, y cargar el controlador correspondiente
 * según la página actual.
 *
 * @package FrontController
 * @author Cristian Mateos
 * @version 1.0
 */

// Inicia la sesión
session_start();

// Página por defecto
if (!isset($_SESSION['paginaEnCurso'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
}

/**
 * Carga el controlador correspondiente
 *
 * Utiliza el arreglo $controller definido en confAPP.php para incluir
 * el archivo PHP que maneja la lógica de la página actual.
 * $_SESSION['paginaEnCurso'] indica qué página se está ejecutando.
 */
require_once ($controller[$_SESSION['paginaEnCurso']]);
?>
