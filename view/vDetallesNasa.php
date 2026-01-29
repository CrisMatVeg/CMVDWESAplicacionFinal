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
    <?php if (!empty($_SESSION['nasa'])) { ?>
        <img src="<?= htmlspecialchars($_SESSION['nasa']['urlHd']) ?>"
            alt="<?= htmlspecialchars($_SESSION['nasa']['titulo']) ?>"
            style="width:600px;height:600px;">
    <?php } else { ?>
        <p>No se pudo cargar la información de la NASA.</p>
    <?php } ?>
</main>