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
 * - Logo con la clase `.owl` y texto “Aplicación Final — Inicio Público”
 * - Formulario de navegación con botón “Login”
 * - Imágenes con clase `.btn secondary` que actúan como elementos interactivos
 *
 * Dependencias:
 * - Estilos definidos en CSS externo e interno del proyecto
 * - Acciones dirigidas a `index.php`
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>
<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Inicio Público</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="submit" name="paginaDestino" value="Login" class="cta">
        </form>
    </nav>
</header>

<main class="publicmain">
    <h1>Inicio Público</h1>
    <div class="imagenes">
        <div>
            <p>Casos de Uso</p>
            <a href="./webroot/images/casosuso.jpg" target="_blank"><img src="./webroot/images/casosuso.jpg" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Navegación</p>
            <a href="./webroot/images/navegacion.jpg" target="_blank"><img src="./webroot/images/navegacion.jpg" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Ficheros</p>
            <a href="./webroot/images/ficheros.jpg" target="_blank"><img src="./webroot/images/ficheros.jpg" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Clases</p>
            <a href="./webroot/images/clases.drawio.png" target="_blank"><img src="./webroot/images/clases.drawio.png" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Modelo Físico</p>
            <a href="./webroot/images/modelofisico.jpg" target="_blank"><img src="./webroot/images/modelofisico.jpg" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Sesión</p>
            <a href="./webroot/images/sesion.jpg" target="_blank"><img src="./webroot/images/sesion.jpg" alt="" class="btn secondary"></a>
        </div>
        <div>
            <p>Requisitos</p>
            <a href="./webroot/images/requisitos.pdf" target="_blank"><img src="./webroot/images/requisitos.jpg" alt="" class="btn secondary"></a>
        </div>
    </div>
</main>