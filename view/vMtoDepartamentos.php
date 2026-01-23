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
            <input type="submit" name="volver" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <h1>Mantenimiento de Departamentos</h1>
        <div>
            <form method="post">
                <label for="descripcion">Buscar Departamento de:</label>
                <input type="text" name="descripcion" id="descripcion">
                <span style="color:red;"></span>

                <input type="submit" name="enviar" value="Buscar" id="enviar">
            </form>
        </div>
    <?php
        echo '<h3>RESULTADO DE BUSQUEDA: </h3>';
        echo '<table>';
        echo '<tr id="titulotabla"><td>Codigo de Departamento</td><td>Descripción</td><td>Fecha de Creación</td><td>Volumen de Negocio</td><td>Fecha de Baja</td></tr>';
        foreach ($departamentos as $departamento) {
            echo '<tr>';
            foreach (get_object_vars($departamento) as $campo => $valor) {
                if (!is_null($valor)) {
                    echo "<td>$valor</td>";
                } else {
                    echo "<td>No Determinado</td>";
                }
            }
            echo "</tr>";
        }
        echo '</table>';
    ?>
</main>