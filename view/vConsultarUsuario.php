<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Consultar Departamento</span></span>
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
                        <input type="text" disabled id="CodUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_CodUsuario?>">
                        <label for="Password">Password:</label>
                        <input type="text" disabled id="Password" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_Password?>">
                        <label for="DescUsuario">Descripción:</label>
                        <input type="text" disabled id="DescUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_DescUsuario?>">
                        <label for="NumConexiones">NºConexiones:</label>
                        <input type="text" disabled id="NumConexiones" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_NumConexiones?>">
                        <label for="FechaHoraUltimaConexion">Fecha de Registro:</label>
                        <input type="text" disabled id="FechaHoraUltimaConexion" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_FechaHoraUltimaConexion?>">
                        <label for="Perfil">Perfil:</label>
                        <input type="text" disabled id="Perfil" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_Perfil?>">
                        <label for="ImagenUsuario">Foto de Perfil:</label>
                        <input type="text" disabled id="ImagenUsuario" value="<?php echo $_SESSION['usuarioSeleccionado']->T01_ImagenUsuario?>">
                    </div>
                </div>
            </fieldset>
        </form>
</main>