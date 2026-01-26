<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Mantenimiento de Departamentos</span></span>
    </div>
    <nav>
        <form method="post">
            <input type="hidden" name="paginaAnterior" value="inicioPublico">
            <input type="submit" name="atras" value="Cerrar Sesión" class="btn primary">
        </form>
        <form method="post">
            <input type="hidden" name="paginaAnterior" value="inicioPrivado">
            <input type="submit" name="volver" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <h1>Mantenimiento de Departamentos</h1>
        <div>
            <form method="post" class="formbuscar">
                <label for="descripcion">Buscar Departamento de:</label>
                <input type="text" name="descripcion" id="descripcion" value="<?php echo(empty($aErrores['descripcion'])) ? ($_SESSION['busquedaDepartamento'] ?? '') : ''; ?>">
                <input type="submit" name="enviar" value="Buscar" id="enviar" class="btn primary">
            </form>
            <span style="color:red;"><?php echo $aErrores['descripcion']; ?></span>
        </div>
    <?php
        if ($entradaOK) {
            if (empty($departamentos)) {
                echo '<p>No se encontraron departamentos.</p>';
            } else {
                echo '<table>';
                echo '<tr class="titulotabla"><td>Codigo de Departamento</td><td>Descripción</td><td>Fecha de Creación</td><td>Volumen de Negocio</td><td>Fecha de Baja</td><td colspan="4">Opciones</td></tr>';
                foreach ($departamentos as $departamento) {
                    echo '<tr>';
                    foreach (get_object_vars($departamento) as $campo => $valor) {
                        if (!is_null($valor)) {
                            echo "<td>$valor</td>";
                        } else {
                            echo "<td>No Determinado</td>";
                        }
                    }
                    $codDpto = $departamento->T02_CodDepartamento;
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codDpto' value='$codDpto'>
                                <button class='opcionDpto' type='submit' name='verDpto'><i class='fa-solid fa-eye'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codDpto' value='$codDpto'>
                                <button class='opcionDpto' type='submit' name='editarDpto'><i class='fa-solid fa-pencil'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codDpto' value='$codDpto'>
                                <button class='opcionDpto' type='submit' name='bajaDpto'><i class='fa-solid fa-circle-down'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codDpto' value='$codDpto'>
                                <button class='opcionDpto' type='submit' name='borrarDpto'><i class='fa-solid fa-trash'></i></button>
                            </form>
                        </td>";

                    echo '</tr>';
                }
                echo '</table>';
            }
        }
    ?>
</main>