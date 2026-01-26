<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— REST</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="hidden" name="paginaAnterior" value="inicioPrivado">
            <input type="submit" name="atras" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <h1>APIs</h1>
    <div class="apimain">
        <div class="nasa apicontainer">
            <h3>API: Nasa</h3>
            <form class="nasaform">
                <input type="date" name="fecha" value="<?php echo htmlspecialchars($_SESSION['fechaFotoNasa']); ?>">
                <input type="submit" name="enviarFecha" value="Enviar" class="btn secondary">
            </form>
            <?php if (isset($_SESSION['fotoDelDia']) && $_SESSION['fotoDelDia'] !== null){ ?>
            <img src="<?= htmlspecialchars($_SESSION['fotoDelDia']['url']) ?>" alt="<?= htmlspecialchars($_SESSION['fotoDelDia']['title']) ?>" style="width:250px;height:250px;">
            <form method="post" action="index.php">
                <input type="submit" name="ampliarnasa" value="Ampliar">
            </form>
            <h4 class="parametrostitulo">Parametros:</h4>
            <div class="modal mnasa">
                <p><b>Titulo: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['title']) ?></p>
                <p><b>Fecha: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['date']) ?></p>
                <p class="pdescripcionnasa truncate-text" id="descripcionNasa"><b>Descripción: </b><br><?= htmlspecialchars($_SESSION['fotoDelDia']['explanation']) ?></p>
                <p><b>Tipo de media: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['media_type']) ?></p>
                <p><b>Versión: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['service_version']) ?></p>
                <p><b>Imagen HD: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['hdurl']) ?></p>
                <p><b>Imagen: </b><?= htmlspecialchars($_SESSION['fotoDelDia']['url']) ?></p>
            </div>
            <?php }else{ ?>
                <p>No se pudo obtener la foto del día de la NASA.</p>
            <?php }; ?>
        </div>
        <div class="dogapi apicontainer">
            <h3>API: DogApi</h3>
            <form class="perroform">
                <select name="razas" id="razas">
                    <option value="" selected>Todas las razas</option>
                    <?php foreach ($listadoRazas as $raza){ ?>
                        <option value="<?= htmlspecialchars($raza) ?>" <?= ($raza === $_SESSION['razaPerroSeleccionada']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($raza) ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="submit" name="enviarRaza" value="Enviar" class="btn secondary">
            </form>
            <?php if ($fotoPerro){ ?>
            <img src="<?= $fotoPerro['message'] ?>" alt="Perro" style="width:250px;height:250px;">
            <a href="#" id="btnabrirmodalperro">Ampliar</a>
            <h4 class="parametrostitulo">Parametros:</h4>
            <div class="modal mperro">
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