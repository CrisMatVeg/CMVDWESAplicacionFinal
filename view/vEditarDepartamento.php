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
                        <label for="codDepartamento">Código de departamento:</label>
                        <input type="text" disabled name="codDepartamento" id="codDepartamento" value="<?php echo $_SESSION['dptoSeleccionado']->T02_CodDepartamento?>">
                        <label for="descDepartamento">Descripción de departamento:</label>
                        <input type="text" class="required" name="descDepartamento" id="descDepartamento" value="<?php echo $_SESSION['dptoSeleccionado']->T02_DescDepartamento?>">
                        <label for="fechaCreacionDepartamento">Fecha de creación de departamento:</label>
                        <input disabled type="text" name="fechaCreacionDepartamento" id="fechaCreacionDepartamento" value="<?php echo $_SESSION['dptoSeleccionado']->T02_FechaCreacionDepartamento?>">
                        <label for="VolumenDeNegocio">Volumen de negocio de departamento:</label>
                        <input type="text" name="VolumenDeNegocio" id="VolumenDeNegocio" value="<?php echo $_SESSION['dptoSeleccionado']->T02_VolumenDeNegocio?>">
                    </div>
                </div>
            </fieldset>
            <input type="submit" name="cambiarDatos" value='Cambiar Datos' class="btn primary">
        </form>
</main>