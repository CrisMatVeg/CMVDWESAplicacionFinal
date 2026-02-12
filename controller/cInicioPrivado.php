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

// Control de sesión obligatoria
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Perfil de administrador
$esAdmin = $_SESSION['usuarioActualDWESAplicacionFinal']->getPerfil() === "admin";

// Navegación a páginas específicas
$redirecciones = [
    'miperfil' => 'MiCuenta',
    'detalle' => 'Detalle',
    'mtoDptos' => 'MtoDepartamentos',
    'mtoUsuarios' => 'MtoUsuariosAPI',
    'rest' => 'REST',
    'error' => 'error'
];

foreach ($redirecciones as $param => $paginaDestino) {
    if (isset($_REQUEST[$param])) {
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

        if ($param === 'error') {
            $consultaError = "SELECT * FROM T03_Cuestion";
            DBPDO::ejecutarConsulta($consultaError, null);
        }

        $_SESSION['paginaEnCurso'] = $paginaDestino;
        header('Location: index.php');
        exit;
    }
}

// Botón "Atrás" / cierre de sesión
if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Preparación de los datos del usuario para la vista
$usuarioActual = $_SESSION['usuarioActualDWESAplicacionFinal'];

$datosUsuarioVista = [
    "codUsuario" => $usuarioActual->getCodUsuario(),
    "numConexiones" => $usuarioActual->getNumConexiones(),
    "fechaHoraUltimaConexionAnterior" => $usuarioActual->getFechaHoraUltimaConexionAnterior(),
    "descUsuario" => $usuarioActual->getDescUsuario(),
    "esAdmin" => $esAdmin
];

$_SESSION['arrayDatosUsuarioActualDWESAplicacionFinal'] = $datosUsuarioVista;

// Carga la vista layout principal
require_once $view["layout"];
