<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— Añadir Departamento</span></span>
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
                    <label for="codDepartamento">Código de departamento:</label>
                    <input type="text" class="required" name="codDepartamento" id="codDepartamento" maxlength="3" value="<?php echo !$aErrores['codDepartamento'] ? $aRespuestas['codDepartamento'] : ''; ?>" oninput="this.value = this.value.toUpperCase();">
                    <span style="color:red;"><?php echo $aErrores['codDepartamento']; ?></span>
                    <label for="descDepartamento">Descripción de departamento:</label>
                    <input type="text" class="required" name="descDepartamento" id="descDepartamento" value="<?php echo !$aErrores['descDepartamento'] ? $aRespuestas['descDepartamento'] : ''; ?>">
                    <span style="color:red;"><?php echo $aErrores['descDepartamento']; ?></span>
                    <label for="VolumenDeNegocio">Volumen de negocio de departamento:</label>
                    <input type="text" class="required" name="VolumenDeNegocio" id="VolumenDeNegocio" value="<?php echo !$aErrores['VolumenDeNegocio'] ? $aRespuestas['VolumenDeNegocio'] : ''; ?>">
                    <span style="color:red;"><?php echo $aErrores['VolumenDeNegocio']; ?></span>
                </div>
            </div>
        </fieldset>
        <input type="submit" name="confirmarAñadir" value='Añadir' class="btn primary">
    </form>
</main>