<?php
/**
 * Vista Parcial: Detalle
 *
 * Este archivo muestra la página de detalle de la aplicación Login/Logoff.
 * Su propósito principal es mostrar información de las superglobales de PHP
 * ($_SESSION, $_COOKIE, $_SERVER, $_ENV, $_REQUEST, $_GET, $_POST, $_FILES)
 * y toda la configuración del servidor mediante `phpinfo()`.
 *
 * Funcionalidad:
 * - `<header>`: logo y formulario con botón "Volver" para regresar a inicio privado.
 * - `<main>`: sección `.hero` que despliega:
 *      - Título del contenido: “Superglobales y phpinfo()”
 *      - Tablas HTML para cada superglobal, mostrando clave y valor
 *      - Salida completa de `phpinfo()` al final
 *
 * Elementos importantes:
 * - Logo con clase `.owl` y texto “Login Logoff — Detalle”
 * - Formulario con botón "Volver" (`paginaAnterior = inicioPrivado`)
 * - Tablas de superglobales para depuración
 * - phpinfo() para información completa del servidor y PHP
 *
 * Dependencias:
 * - Variables de superglobales de PHP
 * - Estilos CSS externos/internos
 * - Archivo PHP de acción del formulario (`indexLoginLogoff.php`)
 *
 * Advertencia:
 * - Esta vista debe usarse solo en entorno de desarrollo o pruebas, 
 *   ya que expone información sensible de la sesión y del servidor.
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>
<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Login Logoff<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Detalle</span></span>
    </div>
    <form method="post" action="indexLoginLogoff.php">
        <input type="hidden" name="paginaAnterior" value="inicioPrivado">
        <input type="submit" name="atras" value="Volver" class="btn primary">
    </form>
</header>

<main>
<section class="hero">
<div>
    <h1>Superglobales y phpinfo()</h1>
    <?php
        // Mostrar información de $_SESSION
        echo '<h1>$_SESSION</h1>';
        echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
        foreach ($_SESSION as $clave => $valor) {
            echo "<tr><th>$clave</th><td>";
            echo "<pre>"; 
            print_r($valor); // Imprime de forma legible el contenido de la variable
            echo "</pre>";
            echo "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_COOKIE
        echo '<h3>$_COOKIE</h3>';
        echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
        foreach ($_COOKIE as $clave => $valor) {
            echo "<tr><th>$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_SERVER
        echo '<h3>$_SERVER</h3>';
        echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
        foreach ($_SERVER as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_ENV
        echo '<h3>$_ENV</h3>';
        echo '<table><tr><th>Variable $_ENV</th><th>Valor</th></tr>';
        foreach ($_ENV as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_REQUEST
        echo '<h3>$_REQUEST</h3>';
        echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
        foreach ($_REQUEST as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_GET
        echo '<h3>$_GET</h3>';
        echo '<table><tr><th>Clave</th><th>Valor</th></tr>';
        foreach ($_GET as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_POST
        echo '<h3>$_POST</h3>';
        echo '<table><tr><th>Variable $_POST</th><th>Valor</th></tr>';
        foreach ($_POST as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información de $_FILES (archivos subidos)
        echo '<h3>$_FILES</h3>';
        echo '<table><tr><th>Variable $_FILES</th><th>Valor</th></tr>';
        foreach ($_FILES as $clave => $valor) {
            echo "<tr><th>$$clave</th><td>" . $valor . "</td></tr>";
        }
        echo '</table>';

        // Mostrar información completa de PHP, configuración del servidor, módulos, etc.
        echo phpinfo();
    ?>
</div>
</section>
</main>