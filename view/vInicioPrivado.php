<?php
/**
 * Vista Parcial: Inicio Privado
 *
 * Este archivo muestra la interfaz de la página de inicio privado
 * de la aplicación Login/Logoff. Se encarga de mostrar un mensaje
 * de bienvenida al usuario, información sobre sus conexiones, 
 * y proporciona un botón para acceder a la página de detalle.
 *
 * Funcionalidad:
 * - `<header>`: muestra el logo y un formulario con botón "Cerrar Sesión".
 * - `<main>`: muestra:
 *      - Bienvenida al usuario con su nombre (`descUsuario`)
 *      - Número de conexiones realizadas (`numConexiones`)
 *      - Fecha y hora de la penúltima conexión (`fechaHoraUltimaConexionAnterior`) si aplica
 *      - Botón para ir a la sección de "Detalle"
 *
 * Elementos importantes:
 * - Logo con clase `.owl` y texto “Login Logoff — Inicio Privado”
 * - Formulario de cierre de sesión con botón "Cerrar Sesión"
 * - Información dinámica extraída del array `$avInicioPrivado`
 * - Botón de navegación a `Detalle`
 *
 * Dependencias:
 * - Variable PHP `$avInicioPrivado` con datos del usuario
 * - Estilos CSS externos e internos
 *
 * @package Vistas
 * @author Cristian Mateos
 * @version 1.0
 */
?>
<header>
    <div class="logo">
        <span class="owl" aria-hidden="true"></span>
        <span>Login Logoff<span style="color:var(--muted);font-weight:600;margin-left:6px;font-size:.9rem">—
            Inicio Privado</span></span>
    </div>
    <nav>
        <form method="post">
            <input type="hidden" name="paginaAnterior" value="inicioPublico">
            <input type="submit" name="atras" value="Cerrar Sesión" class="btn primary">
        </form>
    </nav>
</header>

<main>
    <?php
        echo "<h1>Bienvenido " . $avInicioPrivado["descUsuario"] . "</h1>";
        echo "<h2>Esta el la " . $avInicioPrivado["numConexiones"] + 1 . "ª vez que se conecta.</h2>";
        if($avInicioPrivado["numConexiones"]!=0){
            echo "<h2>Usted se conectó por última vez el ".$avInicioPrivado["fechaHoraUltimaConexionAnterior"]->format('d')." del ".$avInicioPrivado["fechaHoraUltimaConexionAnterior"]->format('m'). " de " .$avInicioPrivado["fechaHoraUltimaConexionAnterior"]->format('Y'). " a las " .$avInicioPrivado["fechaHoraUltimaConexionAnterior"]->format('H').":".$avInicioPrivado["fechaHoraUltimaConexionAnterior"]->format('i')."</h2>";
        }else{
            echo '<h2>BIENVENIDO!</h2>';
        }
        echo '<br>'
    ?>
    <form method="post" class="ipbotones">
        <input type="submit" name="detalle" value='Detalle' class="btn primary">
        <input type="submit" name="rest" value='REST' class="btn primary">
        <input type="submit" name="mantenimiento" value='Mantenimiento Departamentos' class="btn primary">
        <input type="submit" name="error" value='Error' class="btn primary">
    </form>
</main>