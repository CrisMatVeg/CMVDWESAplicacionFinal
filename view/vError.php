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
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Error</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
        </form>
    </nav>
</header>

<main>
    <div class="errorcontenedor">
        <div class="error codigo">
            <h2 id="errorcode">500</h2>
        </div>
        <h1 class="error titulo">ALGO SALIO MAL</h1>
        <div class="error mensaje">
            <p>Código de error: <?php echo $datosError['codError']; ?></p>
            <p>Descripción: <?php echo $datosError['descError']; ?></p>
            <p>Archivo: <?php echo $datosError['archivoError']; ?></p>
            <p>Línea: <?php echo $datosError['lineaError']; ?></p>
        </div>
        <form>
        <input type="submit" name="atras" value="Atras" class="btn primary">
        </form>
    </div>
</main>