<?php
/**
 * Vista Parcial: Inicio Público
 *
 * Este archivo contiene la sección de cabecera y contenido principal
 * para la página de inicio público de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - `<header>`: muestra el logo y un formulario de navegación al login.
 * - `<main>`: contiene un título y un conjunto de imágenes representativas
 *   de distintas secciones del proyecto (navegación, ficheros, clases, modelo físico).
 *
 * Elementos importantes:
 * - Logo con la clase `.owl` y texto “Login Logoff — Inicio Público”
 * - Formulario de navegación con botón “Login”
 * - Imágenes con clase `.btn secondary` que actúan como elementos interactivos
 *
 * Dependencias:
 * - Estilos definidos en CSS externo e interno del proyecto
 * - Acciones dirigidas a `indexLoginLogoff.php`
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>
<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Login Logoff<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Work In Progress</span></span>
    </div>
    <nav>
        <form method="post" action="indexLoginLogoff.php">
            <input type="submit" name="atras" value="Cancelar" class="btn primary">
        </form>
    </nav>
</header>

<main class="mainwip">
    <h1>WORK IN PROGRESS</h1>
    <img src="./webroot/images/paloma.svg" alt="imagen logo" class="imgwip">
</main>