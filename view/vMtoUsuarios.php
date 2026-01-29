<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Mantenimiento de Usuarios</span></span>
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

<main class="mainUsuarios">
    <h1>Mantenimiento de Usuarios</h1>
        <div>
            <form method="post" class="formbuscar">
                <label for="descripcion">Buscar Usuario:</label>
                <input type="text" name="descripcion" id="descripcion" value="<?php echo(empty($aErrores['descripcion'])) ? ($_SESSION['busquedaUsuario'] ?? '') : ''; ?>">
                <input type="submit" name="enviar" value="Buscar" id="enviar" class="btn primary">
            </form>
            <span style="color:red;"><?php echo $aErrores['descripcion']; ?></span>
        </div>
    <?php
        if ($entradaOK) {
            if (empty($usuarios)) {
                echo '<p>No se encontraron departamentos.</p>';
            } else {
                echo '<table>';
                echo '<tr class="titulotabla"><td>Username</td><td>Password</td><td>Descripción</td><td>Nº Conexiónes</td><td>Fecha de Registro</td><td>Perfil</td><td>Foto de Perfil</td><td colspan="4">Opciones</td></tr>';
                foreach ($usuarios as $usuario) {
                    echo '<tr>';
                    foreach (get_object_vars($usuario) as $campo => $valor) {
                        if (!is_null($valor)) {
                            echo "<td>$valor</td>";
                        } else {
                            echo "<td>No Determinado</td>";
                        }
                    }
                    $codUsuario = $usuario->T01_CodUsuario;
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codUsuario' value='$codUsuario'>
                                <button class='opcionUsuario' type='submit' name='verUsuario'><i class='fa-solid fa-eye'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codUsuario' value='$codUsuario'>
                                <button class='opcionUsuario' type='submit' name='editarUsuario'><i class='fa-solid fa-pencil'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codUsuario' value='$codUsuario'>
                                <button class='opcionUsuario' type='submit' name='bajaUsuario'><i class='fa-solid fa-circle-down'></i></button>
                            </form>
                        </td>";
                    echo "<td>
                            <form method='post' style='display:inline'>
                                <input type='hidden' name='codUsuario' value='$codUsuario'>
                                <button class='opcionUsuario' type='submit' name='borrarUsuario'><i class='fa-solid fa-trash'></i></button>
                            </form>
                        </td>";

                    echo '</tr>';
                }
                echo '</table>';
            }
        }
    ?>
</main>