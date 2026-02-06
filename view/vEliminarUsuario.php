<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Eliminar Usuario</span></span>
    </div>
    <nav>
        <form method="post">
            <input type="submit" name="volver" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <h1>Seguro que quieres eliminar al usuario que se llama <?php echo $_SESSION['codUsuarioSeleccionado'] ?>?</h1>
    <h3>Introduzca "SI" si quiere eliminarlo</h3>
    <div>
        <form method="post">
            <input type="text" name="confirmacion" id="confirmacion">
            <input type="submit" name="confirmar" value='Confirmar' class="btn primary">
        </form>
    </div>
</main>