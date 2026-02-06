<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Cambiar Password</span></span>
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
    <h3>Introduzca su contraseña actual y la nueva</h3>
    <div>
        <form method="post" action="index.php">
            <input type="password" id="passwordactual" name="passwordactual" placeholder="Actual">
            <input type="password" id="passwordnueva" name="passwordnueva" placeholder="Nueva Contraseña">
            <input type="password" id="confirmarpasswordnueva" name="confirmarpasswordnueva" placeholder="Confirmar Nueva Contraseña">
            <input type="submit" name="confirmar" value='Confirmar' class="btn primary">
        </form>
    </div>
</main>