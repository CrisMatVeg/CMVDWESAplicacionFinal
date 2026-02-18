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
                        <label for="codDepartamento">Código de departamento:</label>
                        <input type="text" disabled id="codDepartamento" value="<?php echo $avConsultarDpto["codDepartamento"]?>">
                        <label for="descDepartamento">Descripción de departamento:</label>
                        <input type="text" disabled id="descDepartamento" value="<?php echo $avConsultarDpto["descDepartamento"]?>">
                        <label for="fechaCreacionDepartamento">Fecha de creación de departamento:</label>
                        <input type="text" disabled id="fechaCreacionDepartamento" value="<?php 
                            $avConsultarDpto["fechaCreacionDepartamento"] = date('d/m/Y H:i:s', strtotime($avConsultarDpto["fechaCreacionDepartamento"])); 
                            echo $avConsultarDpto["fechaCreacionDepartamento"];?>">
                        <label for="VolumenDeNegocio">Volumen de negocio de departamento:</label>
                        <input type="text" disabled id="VolumenDeNegocio" value="<?php 
                            $avConsultarDpto["VolumenDeNegocio"]=number_format($avConsultarDpto["VolumenDeNegocio"], 2, ',', '.') . ' €';
                            echo $avConsultarDpto["VolumenDeNegocio"];?>">
                        <label for="FechaDeBaja">Fecha de Baja:</label>
                        <input type="text" disabled id="FechaDeBaja" value="<?php echo $avConsultarDpto["fechaBajaDepartamento"]?? "---"?>">
                    </div>
                </div>
            </fieldset>
        </form>
</main>