<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Mantenimiento de Usuarios</span></span>
    </div>
    <nav>
        <form method="post">
            <input type="hidden" name="paginaAnterior" value="inicioPublico">
            <input type="submit" onclick="cerrarSesion()" name="atras" value="Cerrar Sesión" class="btn primary">
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
        <form method="post" class="formbuscar" id="formbuscar">
            <label for="descripcion">Descripción buscada:</label>
            <input type="text" name="descripcion" id="descripcion" value="">
        </form>
    </div>

    <table id="tablaUsuarios">
        <thead>
        <tr class="titulotabla">
            <td>Username</td>
            <td>Descripción</td>
            <td>Nº Conexiónes</td>
            <td>Fecha de Registro</td>
            <td>Perfil</td>
            <td colspan="2">Opciones</td>
        </tr>
        </thead>
        <tbody>
            <!-- AQUÍ ENTRA JS -->
        </tbody>
    </table>
</main>

<script src="./webroot/js/usuarios.js"></script>