<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Borrar Usuario</span></span>
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
    <h1>Seguro que quieres borrar tu cuenta?</h1>
    <h3>Introduzca SI o NO</h3>
    <div>
        <form method="post">
            <input type="text" id="confirmacion">
            <input type="submit" name="confirmar" value='Confirmar' class="btn primary">
        </form>
    </div>
</main>