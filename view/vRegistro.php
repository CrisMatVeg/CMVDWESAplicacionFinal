<?php
/**
 * Vista: Registro de usuario (vRegistro)
 *
 * Esta vista muestra la interfaz de registro de nuevos usuarios
 * de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * 1. Muestra el encabezado de la aplicación:
 *    - Incluye el logotipo y el nombre de la aplicación.
 *    - Indica visualmente que el usuario se encuentra en la sección de Registro.
 *
 * 2. Muestra el título principal de la página:
 *    - El texto del título se adapta dinámicamente según la cookie `idioma`:
 *       - "FR" → SE CONNECTER
 *       - "PR" → CONECTE-SE
 *       - Cualquier otro valor → INICIAR SESIÓN
 *    - Si no existe la cookie `idioma`, se muestra el título "REGISTRO".
 *
 * 3. Muestra el formulario de alta de usuario:
 *    - Campos del formulario:
 *       - `codUsuario`: código de usuario
 *       - `descUsuario`: nombre completo del usuario
 *       - `password`: contraseña
 *    - El formulario envía los datos mediante POST a `indexLoginLogoff.php`.
 *
 * 4. Navegación:
 *    - Botón "Entrar" para enviar el formulario y realizar el alta.
 *    - Botón "Login" para volver a la pantalla de inicio de sesión.
 *    - Campo oculto `paginaAnterior` para mantener la navegación correcta.
 *
 * Dependencias:
 * - Cookie `idioma` para la internacionalización básica del título
 * - Controlador frontal `indexLoginLogoff.php`
 * - Variables de formulario enviadas por método POST
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>

<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>
            Login Logoff
            <span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">
                — Registro
            </span>
        </span>
    </div>
</header>

<main>
    <section class="hero">
        <div>
            <?php
                if (isset($_COOKIE["idioma"])) {
                    if ($_COOKIE["idioma"] == "FR") {
                        echo "<h2>SE CONNECTER</h2>";
                    } elseif ($_COOKIE["idioma"] == "PR") {
                        echo "<h2>CONECTE-SE</h2>";
                    } else {
                        echo "<h2>INICIAR SESIÓN</h2>";
                    }
                } else {
                    echo "<h2>REGISTRO</h2>";
                }
            ?>
            <div>
                <form method="post" action="indexLoginLogoff.php">
                    <input type="text" name="codUsuario" placeholder="Usuario" id="codUsuario" class="required" value="">
                    <input type="text" name="descUsuario" placeholder="Nombre Completo" id="descUsuario" class="required" value="">
                    <input type="password" name="password" placeholder="Contraseña" id="password" class="required" value="">

                    <div>
                        <!-- Botón para enviar el formulario -->
                        <input type="submit" name="acceso" value="inicioPrivado" class="btn primary">

                        <!-- Botón para volver al login -->
                        <input type="hidden" name="paginaAnterior" value="Login">
                        <input type="submit" name="atras" value="Login" class="btn primary">
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
