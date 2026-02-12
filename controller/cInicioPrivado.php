<?php
/**
 * Controlador: Inicio Privado
 *
 * Este controlador gestiona la página de inicio privado de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Determina si el usuario tiene perfil de administrador.
 * - Gestiona la navegación hacia:
 *      - Mi cuenta
 *      - Detalle de usuario
 *      - Mantenimiento de departamentos
 *      - Mantenimiento de usuarios API
 *      - REST
 *      - Error
 * - Gestiona el botón "Atrás" / cierre de sesión:
 *      - Destruye la sesión y vuelve a la página anterior
 * - Prepara los datos del usuario para la vista (`$datosUsuarioVista`):
 *      - Código de usuario
 *      - Número de conexiones
 *      - Fecha y hora de última conexión anterior
 *      - Descripción del usuario
 *      - Perfil administrador
 * - Carga la vista principal (`layout`) con los datos preparados.
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Clase `Usuario` para obtener información del usuario
 * - Clase `DBPDO` para consultas de error
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if ($_SESSION['usuarioActualDWESAplicacionFinal']->getPerfil()=="admin") {
    $esAdmin=true;
}else{
    $esAdmin=false;
}

if (isset($_REQUEST['miperfil'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'MiCuenta';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'Detalle';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['mtoDptos'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['mtoUsuarios'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['rest'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'REST';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError,null);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    /* UsuarioPDO::guardarToken($codUsuario, null); */
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Preparación de los datos del usuario para la vista
$avInicioPrivado = [
    "codUsuario" => $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario(),
    "numConexiones" => $_SESSION['usuarioActualDWESAplicacionFinal']->getNumConexiones(),
    "fechaHoraUltimaConexionAnterior" => $_SESSION['usuarioActualDWESAplicacionFinal']->getFechaHoraUltimaConexionAnterior(),
    "descUsuario" => $_SESSION['usuarioActualDWESAplicacionFinal']->getDescUsuario(),
    $esAdmin
];
$_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal']=$avInicioPrivado;

// Carga la vista layout principal
require_once $view["layout"];
