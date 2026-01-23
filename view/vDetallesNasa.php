<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— API: NASA</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="submit" name="atras" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <img src="<?= htmlspecialchars($_SESSION['fotoDelDia']['url']) ?>" alt="<?= htmlspecialchars($_SESSION['fotoDelDia']['title']) ?>" style="width:600px;height:600px;">
    <p>Explicación de como se usa la api...</p>
</main>