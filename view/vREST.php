<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— REST</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="submit" name="atras" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <h1>APIs</h1>
    <div class="apimain">
        <div class="nasa apicontainer">
            <form class="nasaform">
                <input type="date" name="fecha" value="<?php echo htmlspecialchars($_SESSION['fechaFotoNasa']); ?>">
                <input type="submit" name="enviarFecha" value="Enviar" class="btn secondary">
            </form>
            <?php if (isset($fotoDelDia) && $fotoDelDia !== null){ ?>
            <img src="<?= htmlspecialchars($fotoDelDia['url']) ?>" alt="<?= htmlspecialchars($fotoDelDia['title']) ?>" style="width:400px;height:400px;">
            <a href="#" id="btnabrirmodal">Ver más detalles...</a>
            <div class="modal mnasa">
                <a href="" id="btncerrarmodal">Cerrar</a>
                <p><b>Titulo: </b><?= htmlspecialchars($fotoDelDia['title']) ?></p>
                <p><b>Fecha: </b><?= htmlspecialchars($fotoDelDia['date']) ?></p>
                <p><b>Descripción: </b><br><?= htmlspecialchars($fotoDelDia['explanation']) ?></p>
                <p><b>Tipo de media: </b><?= htmlspecialchars($fotoDelDia['media_type']) ?></p>
                <p><b>Versión: </b><?= htmlspecialchars($fotoDelDia['service_version']) ?></p>
                <p><b>URL HD: </b><?= htmlspecialchars($fotoDelDia['hdurl']) ?></p>
                <p><b>URL: </b><?= htmlspecialchars($fotoDelDia['url']) ?></p>
            </div>
            <?php }else{ ?>
                <p>No se pudo obtener la foto del día de la NASA.</p>
            <?php }; ?>
        </div>
        <div class="dogapi apicontainer">
            <form class="perroform">
                <select name="razas" id="razas">
                    <option value="" selected>Todas las razas</option>
                    <?php foreach ($listadoRazas as $raza): ?>
                        <option value="<?= htmlspecialchars($raza) ?>" <?= ($raza === $_SESSION['razaPerroSeleccionada']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($raza) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="enviarRaza" value="Enviar" class="btn secondary">
            </form>
            <?php if ($fotoPerro){ ?>
            <img src="<?= $fotoPerro['message'] ?>" alt="Perro" style="width:400px;height:400px;">
            <a href="#" id="btnabrirmodalperro">Ver más detalles...</a>
            <div class="modal mperro">
                <a href="" id="btncerrarmodalperro">Cerrar</a>
                <p><b>Mensaje (Foto): </b><?= htmlspecialchars($fotoPerro['message']) ?></p>
                <p><b>Status: </b><?= htmlspecialchars($fotoPerro['status']) ?></p>
            </div>
            <?php }else{ ?>
                <p>No se pudo obtener la foto del perro.</p>
            <?php }; ?>
        </div>
        <div class="miapi apicontainer"></div>
    </div>
</main>