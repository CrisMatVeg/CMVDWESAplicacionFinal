<?php
/**
 * Vista Parcial: Login
 *
 * Este archivo contiene la sección de cabecera y contenido principal
 * para la página de Login de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - `<header>`: muestra el logo y un formulario con botón "Registrarse".
 * - `<main>`: contiene la sección principal (`.hero`) con el formulario
 *   de login que permite introducir usuario y contraseña, y botones de acción.
 *
 * Elementos importantes:
 * - Logo con la clase `.owl` y texto “Login Logoff — Login”
 * - Formulario de registro con botón "Registrarse"
 * - Formulario de login con campos `codUsuario` y `password`
 * - Botones de acción:
 *   - "Entrar" (`paginaDestino = inicioPrivado`)
 *   - "Cancelar" (`atras` con valor de página anterior)
 *
 * Dependencias:
 * - Estilos CSS externos e internos
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
        <span>Login Logoff<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Login</span></span>
    </div>
    <form>
        <input type="submit" name="registro" value='Registrarse' id="registro" class="btn secondary">
    </form>
</header>

<main>
    <section class="hero">
        <div>
            <?php
                if(isset($_COOKIE["idioma"])){
                    if($_COOKIE["idioma"]=="FR"){
                        echo "<h2>SE CONNECTER</h2>";
                    }elseif ($_COOKIE["idioma"]=="PR") {
                        echo "<h2>CONECTE-SE</h2>";
                    }else{
                        echo "<h2>INICIAR SESIÓN</h2>";
                    }
                }else{
                    echo "<h2>INICIAR SESIÓN</h2>";
                }
            ?>
            <div>
                <form method="post" action="indexLoginLogoff.php">
                    <input type="text" name="codUsuario" placeholder="Usuario" id="codUsuario" class="required" value="">
                    <input type="password" name="password" placeholder="Contraseña" id="password" value="">

                    <div>
                        <!-- Input submit Entrar -->
                        <input type="submit" name="paginaDestino" value="inicioPrivado" class="btn primary">

                        <!-- Input submit Cancelar con un valor oculto para que sepa cual es la anterior exacta al pulsar este boton-->
                        <input type="hidden" name="paginaAnterior" value="inicioPublico">
                        <input type="submit" name="atras" value="Cancelar" class="btn primary">
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>