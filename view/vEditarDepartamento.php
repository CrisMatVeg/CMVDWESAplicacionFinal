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
                        <input type="text" disabled name="codDepartamento" id="codDepartamento" value="<?php echo $avConsultarDpto["codDepartamento"]?>">
                        <label for="descDepartamento">Descripción de departamento:</label>
                        <input type="text" class="required" name="descDepartamento" id="descDepartamento" value="<?php echo $avConsultarDpto["descDepartamento"]?>">
                        <span style="color:red;"><?php echo $aErrores['descDepartamento']; ?></span>
                        <label for="fechaCreacionDepartamento">Fecha de creación de departamento:</label>
                        <input disabled type="text" name="fechaCreacionDepartamento" id="fechaCreacionDepartamento" value="<?php $avConsultarDpto["fechaCreacionDepartamento"] = date('d/m/Y H:i:s', strtotime($avConsultarDpto["fechaCreacionDepartamento"])); 
                            echo $avConsultarDpto["fechaCreacionDepartamento"];?>">
                        <label for="VolumenDeNegocio">Volumen de negocio de departamento:</label>
                        <input type="text" class="required" name="VolumenDeNegocio" id="VolumenDeNegocio" value="<?php $avConsultarDpto["VolumenDeNegocio"]=number_format($avConsultarDpto["VolumenDeNegocio"], 2, ',', '.') . ' €';
                            echo $avConsultarDpto["VolumenDeNegocio"];?>">
                        <span style="color:red;"><?php echo $aErrores['VolumenDeNegocio']; ?></span>
                        <label for="FechaDeBaja">Fecha de Baja:</label>
                        <input disabled type="text" disabled id="FechaDeBaja" value="<?php echo $avConsultarDpto["fechaBajaDepartamento"] ?? "---"?>">
                    </div>
                </div>
            </fieldset>
            <input type="submit" name="cambiarDatos" value='Cambiar Datos' class="btn primary">
        </form>
</main>