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

<main class="detalleapi">
    <?php if (!empty($_SESSION['nasa'])) { ?>
        <h3><?= htmlspecialchars($_SESSION['nasa']['fecha']) ?></h3>
        <img src="<?= htmlspecialchars($_SESSION['nasa']['urlHd']) ?>"
            alt="No se ha podido cargar la imagen"
            style="width:100%;height:100%;">
            <section class="documentacion-api">
                <h2>Documentación API NASA</h2>

                <p>
                    La API <b>APOD (Astronomy Picture of the Day)</b> de la NASA permite obtener
                    la imagen astronómica del día junto con información descriptiva asociada.
                    Esta API es pública y se accede mediante peticiones HTTP de tipo GET.
                </p>

                <h3>Endpoint</h3>
                <pre>https://api.nasa.gov/planetary/apod</pre>

                <h3>Parámetros</h3>
                <table border="1" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Parámetro</th>
                            <th>Tipo</th>
                            <th>Obligatorio</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>api_key</td>
                            <td>string</td>
                            <td>Sí</td>
                            <td>Clave de acceso proporcionada por la NASA</td>
                        </tr>
                        <tr>
                            <td>date</td>
                            <td>string (YYYY-MM-DD)</td>
                            <td>No</td>
                            <td>Fecha de la imagen a consultar. Si no se indica, se devuelve la imagen del día actual</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Ejemplo de petición</h3>
                <a target="_blank" href="https://api.nasa.gov/planetary/apod?api_key=aJQGMfgeU4awVVTZeZeGMd5f6584nCyFtm4Ud4h1&date=2023-10-01">https://api.nasa.gov/planetary/apod?api_key=aJQGMfgeU4awVVTZeZeGMd5f6584nCyFtm4Ud4h1&date=2023-10-01</a>

                <h3>Respuesta</h3>
                <p>
                    La API devuelve un objeto JSON con información sobre la imagen o contenido multimedia.
                </p>

                <h3>Campos principales de la respuesta</h3>
                <table border="1" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Campo</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>title</td>
                            <td>string</td>
                            <td>Título de la imagen</td>
                        </tr>
                        <tr>
                            <td>date</td>
                            <td>string</td>
                            <td>Fecha de publicación</td>
                        </tr>
                        <tr>
                            <td>explanation</td>
                            <td>string</td>
                            <td>Descripción detallada del contenido</td>
                        </tr>
                        <tr>
                            <td>url</td>
                            <td>string</td>
                            <td>URL del recurso principal (imagen o vídeo)</td>
                        </tr>
                        <tr>
                            <td>hdurl</td>
                            <td>string</td>
                            <td>URL de la imagen en alta definición (si existe)</td>
                        </tr>
                        <tr>
                            <td>media_type</td>
                            <td>string</td>
                            <td>Tipo de contenido: image o video</td>
                        </tr>
                        <tr>
                            <td>service_version</td>
                            <td>string</td>
                            <td>Versión del servicio de la API</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Uso en esta aplicación</h3>
                <p>
                    En esta aplicación, la API de la NASA se consume a través de un modelo REST común,
                    que realiza la petición HTTP y devuelve la respuesta decodificada.
                    Posteriormente, el modelo NASA procesa estos datos y los expone al controlador,
                    que finalmente los envía a la vista para su visualización.
                </p>

                <p>
                    El usuario puede seleccionar una fecha concreta para consultar la imagen asociada a ese día,
                    o dejar el campo vacío para obtener la imagen del día actual.
                </p>
            </section>
    <?php } else { ?>
        <p>No se pudo cargar la información de la NASA.</p>
    <?php } ?>
</main>