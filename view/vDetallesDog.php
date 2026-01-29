<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Aplicación Final<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">— API: Api Dog</span></span>
    </div>
    <nav>
        <form method="post" action="index.php">
            <input type="submit" name="atras" value="Volver" class="btn primary">
        </form>
    </nav>
</header>

<main class="detalleapi">
    <?php if (!empty($_SESSION['perro'])) { ?>
        <h3><?= htmlspecialchars($_SESSION['perro']['estado']) ?></h3>
        <img src="<?= htmlspecialchars($_SESSION['perro']['imagen']) ?>"
            alt="No se ha podido cargar la imagen"
            style="width:100%;height:100%;">
            <section class="documentacion-api">
                <h2>Documentación API Dog</h2>

                <p>
                    La <strong>Dog API</strong> permite obtener imágenes aleatorias de perros y consultar
                    el listado completo de razas disponibles. Es una API pública que no requiere
                    autenticación mediante clave.
                </p>

                <h3>Endpoint principal</h3>
                <pre>https://dog.ceo/api/</pre>

                <h3>Endpoints utilizados</h3>
                <table border="1" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Endpoint</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>/breeds/image/random</td>
                            <td>Obtiene una imagen aleatoria de un perro (cualquier raza)</td>
                        </tr>
                        <tr>
                            <td>/breed/{raza}/images/random</td>
                            <td>Obtiene una imagen aleatoria de una raza concreta</td>
                        </tr>
                        <tr>
                            <td>/breeds/list/all</td>
                            <td>Devuelve el listado completo de razas y subrazas disponibles</td>
                        </tr>
                    </tbody>
                </table>

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
                            <td>raza</td>
                            <td>string</td>
                            <td>No</td>
                            <td>
                                Nombre de la raza del perro.  
                                Para subrazas se utiliza el formato: <code>raza/subraza</code>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h3>Ejemplos de petición</h3>
                <a href="https://dog.ceo/api/breeds/image/random">https://dog.ceo/api/breeds/image/random</a>
                <a href="https://dog.ceo/api/breed/hound/images/random">https://dog.ceo/api/breed/hound/images/random</a>
                <a href="https://dog.ceo/api/breed/bulldog/french/images/random">https://dog.ceo/api/breed/bulldog/french/images/random</a>
                
                <h3>Respuesta</h3>
                <p>
                    La API devuelve un objeto JSON con la imagen solicitada y el estado de la petición.
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
                            <td>message</td>
                            <td>string</td>
                            <td>URL de la imagen del perro</td>
                        </tr>
                        <tr>
                            <td>status</td>
                            <td>string</td>
                            <td>Estado de la respuesta (normalmente "success")</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Listado de razas</h3>
                <p>
                    El endpoint <code>/breeds/list/all</code> devuelve un objeto con todas las razas y subrazas.
                    En esta aplicación, estos datos se procesan para generar un listado plano que se utiliza
                    para rellenar un elemento <code>&lt;select&gt;</code> en la vista.
                </p>

                <h3>Uso en esta aplicación</h3>
                <p>
                    La comunicación con la Dog API se realiza a través del modelo REST común,
                    que se encarga de efectuar las peticiones HTTP.
                    El modelo DogApi procesa la respuesta y adapta los datos al dominio de la aplicación.
                </p>

                <p>
                    El usuario puede seleccionar una raza concreta o dejar la opción por defecto
                    para obtener una imagen aleatoria de cualquier perro.
                </p>
            </section>
    <?php } else { ?>
        <p>No se pudo cargar la información de la NASA.</p>
    <?php } ?>
</main>