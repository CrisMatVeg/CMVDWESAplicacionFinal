<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Editar Departamento</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="submit" name="atras" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <form method="post" class="edicion dpto">
        <fieldset>
            <div>
                <div>
                    <label for="CodUsuario">Username:</label>
                    <input type="text" disabled id="CodUsuario" name="CodUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_CodUsuario ?>">
                    <label for="DescUsuario">Descripción:</label>
                    <input type="text" class="required" id="DescUsuario" name="DescUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_DescUsuario ?>">
                    <label for="NumConexiones">NºConexiones:</label>
                    <input type="text" disabled id="NumConexiones" name="NumConexiones" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_NumConexiones ?>">
                    <label for="FechaHoraUltimaConexion">Fecha de Registro:</label>
                    <input type="text" disabled id="FechaHoraUltimaConexion" name="FechaHoraUltimaConexion" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_FechaHoraUltimaConexion ?>">
                    <label for="Perfil">Perfil:</label>
                    <select class="required" name="Perfil" id="Perfil" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_Perfil ?>">
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <label for="ImagenUsuario">Foto de Perfil:</label>
                    <input type="text" disabled id="ImagenUsuario" name="ImagenUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_ImagenUsuario ?>">
                </div>
            </div>
        </fieldset>
        <input type="submit" name="cambiarDatos" value='Cambiar Datos' class="btn primary">
    </form>
    <form method="post" class="edicion dpto">
        <fieldset>
            <div>
                <div>
                    <legend>Cambiar Contraseña:</legend>
                    <input type="password" id="passwordactual" name="passwordactual" placeholder="Contraseña Actual">
                    <input type="password" id="passwordnueva" name="passwordnueva" placeholder="Nueva Contraseña">
                </div>
            </div>
        </fieldset>
        <input type="submit" name="confirmar" value='Confirmar' class="btn primary">
    </form>
</main>