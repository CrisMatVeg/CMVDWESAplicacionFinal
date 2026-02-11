<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Consultar Usuario</span></span>
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
                        <input type="text" disabled id="CodUsuario" value="<?php echo $avConsultarUsuario["codUsuario"]?>">
                        <label for="DescUsuario">Descripción:</label>
                        <input type="text" disabled id="DescUsuario" value="<?php echo $avConsultarUsuario["descUsuario"]?>">
                        <label for="NumConexiones">NºConexiones:</label>
                        <input type="text" disabled id="NumConexiones" value="<?php echo $avConsultarUsuario["numConexiones"]?>">
                        <label for="FechaHoraUltimaConexion">Fecha de Registro:</label>
                        <input type="text" disabled id="FechaHoraUltimaConexion" value="<?php echo $avConsultarUsuario["fechaHoraUltimaConexion"]?>">
                        <label for="Perfil">Perfil:</label>
                        <input type="text" disabled id="Perfil" value="<?php echo $avConsultarUsuario["perfil"]?>">
                    </div>
                </div>
            </fieldset>
        </form>
</main>