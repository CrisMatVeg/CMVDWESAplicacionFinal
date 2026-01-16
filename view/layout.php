<?php
/**
 * Vista Login/Logoff
 *
 * Este archivo es la plantilla principal de la interfaz de login y logoff.
 * Incluye la estructura HTML, enlaces a hojas de estilo y scripts,
 * definición de fuentes y variables CSS, y carga dinámica de la vista
 * correspondiente según la página en curso en la sesión.
 *
 * Dependencias:
 * - $view[$_SESSION['paginaEnCurso']] → archivo PHP de vista que se carga dinámicamente
 *
 * Funcionalidad:
 * - Define la estructura HTML5 con `<header>`, `<main>` y `<footer>`
 * - Carga CSS externo y define estilos internos para el login/logoff
 * - Muestra enlaces a recursos externos (Font Awesome, Duolingo, Github)
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Logoff</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./webroot/css/estilosLoginLogoff.css">

        <style>
            @font-face {
                font-family: "mFeather";
                src: url("./webroot/fonts/Nunito/static/Nunito-Black.ttf") format("truetype");
                font-weight: 700;
                font-style: normal;
            }

            @font-face {
                font-family: "mNunito";
                src: url("./webroot/fonts/Nunito/Nunito-VariableFont_wght.ttf") format("truetype");
                font-weight: bold;
                font-style: normal;
            }

            :root {
                --brand-green: #58cc02;
                --accent: #4a9bff;
                --footera: #A5ED6E;
                --footertext: #D7FFB8;
                --campocolor: #f7f7f7;
                --text: #1a1a1a;
                --btnsazul: #1fc2ff;
                --muted: #6b7280;
                --max-width: 100vw;
                --btnshadowblue: #1AA8EB;
                --btnshadowgreen:#58A700;
                --btngrisshadow: #cecece;
                --bg: #ffffff;
                --headline: 'mFeather';
                --body: 'mNunito';
            }

            footer {
                background: var(--brand-green);
                margin-top: 3rem;
                padding: 2rem 0;
                color: var(--muted);
                font-size: .9rem;
                position:static;
                bottom:0;
                width: 100%;
            }

            pre,td{
                text-align: start;
                padding-left:10px;
            }

            main{
                background-color: var(--bg);
                text-align:center;
                padding: 100px 20px 20px;
            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 0;
                padding-left:20px;
                padding-right:20px;
                position:fixed;
                top:0;
                background: var(--bg);
                z-index: 1000;
            }

            .logo .owl {
                width: 60px;
                height: 60px;
                background-image: url("./webroot/images/paloma.svg");
                background-size:cover;
                background-repeat: no-repeat;
                display: inline-block;
            }

            #es, #pr, #fr {
                display: none;
            }

            img{
                height: 30px;
            }

            .imgwip{
                width:100px;
                height:100px;
            }

            .ipbotones{
                display:flex;
                flex-direction:row;
            }

            .errorcontenedor{
                color: red;
                display:flex;
                flex-direction: column;
                align-items: center;
            }
            .error.titulo{
                color:red;
            }

            .error.mensaje{
                display:flex;
                flex-direction:column;
                justify-content:center;
                align-items:start;
                margin-bottom:20px;
            }

            .mainwip{
                display: flex;
                justify-content:center;
                align-items:center;
            }

            form{
                display: flex;
                justify-content:center;
                align-content:center;
                flex-direction:column;
                flex-wrap:wrap;
                gap:20px;
            }

            form *{
                cursor: pointer;
            }

            form *{
                justify-content:center;
            }

            form div{
                display: flex;
                justify-content:space-between;
            }

            .labels{
                display: flex;
                justify-content:center;
                align-content:center;
                gap:10px;
                padding-top:10px;
            }

            .cta {
                width: 120px;
                box-shadow: 0px 5px 0px 0px var(--btnshadowgreen);
            }

            .hero div img{
                width: 700px;
                height: 450px;
            }

            .selected-idioma img{
                border:4px solid var(--accent);
                border-radius:10px; 
            }

            .btn.primary {
                width: auto;
                background: var(--btnsazul);
                color: white;
                box-shadow: 0px 5px 0px 0px var(--btnshadowblue);
            }

            .btn.secondary {
                border: 2px solid var(--btngrisshadow);
            }
        </style>
    </head>
    <body>
        <div class="container">
        <?php
            require_once $view[$_SESSION['paginaEnCurso']];
        ?>
            <footer>
                <div class="footer-grid">
                    <div>© 2025-26 IES Los Sauces. Todos los derechos reservados. <a href="../CMVDWESProyectoDWES/indexProyectoDWES.php" title="Inicio">Cristian Mateos Vega</a></div>
                    <div>
                        <a href="https://es.duolingo.com/" target="_blank" title="Duolingo">Pagina Imitada</a>
                        ·
                        <a href="https://github.com/CrisMatVeg/CMVDWESLoginLogoff" target="_blank" title="Github"><i class="fa-brands fa-github fa-2xl"></i></a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
