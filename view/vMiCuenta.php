<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Mi Cuenta</span></span>
    </div>
    <nav>
        <form method="post">
            <input type="hidden" name="paginaAnterior" value="inicioPublico">
            <input type="submit" onclick="cerrarSesion()" name="atras" value="Cerrar Sesión" class="btn primary">
        </form>
        <form method="post">
            <input type="submit" name="volver" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main class="perfilmain">
    <div class="perfilshow">
        <img src="http://picsum.photos/id/654/500/500" alt="">
        <?php
            echo "<h2>".$_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal']["descUsuario"]."</h2>";
            echo "<h3>".$_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal']["codUsuario"]."</h3>";
        ?>
    </div>
    <div>
        <form method="post" class="edicion">
            <fieldset>
                <legend>Datos de Usuario:</legend>
                <div>
                    <div>
                        <label for="description">Description:</label>
                        <input type="text" id="description" name="description">
                    </div>
                </div>
                <input type="submit" name="cambiarDatos" value='Cambiar Datos' class="btn primary">
            </fieldset>
        </form>
        <div class="botoneseditar">
            <form method="post">
                <input type="submit" name="borrarCuenta" value="Borrar Cuenta" class="btn borrar">
            </form>
            <form method="post">
                <input type="submit" name="cambiarContraseña" value="Cambiar Contraseña" class="btn primary">
            </form>
        </div>
    </div>
</main>