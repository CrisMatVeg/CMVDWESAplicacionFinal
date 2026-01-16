<?php
/**
 * Controlador: Inicio Privado (cInicioPrivado)
 *
 * Este controlador gestiona la página de inicio privado de la aplicación Login/Logoff.
 * Se encarga de validar la sesión del usuario, manejar la navegación entre páginas,
 * y preparar los datos del usuario para la vista.
 *
 * Funcionalidad:
 * 1. Validación de sesión:
 *    - Si no existe `$_SESSION['usuarioActualDWESLoginLogoff']`, redirige a la página de Login.
 *
 * 2. Navegación hacia otra página:
 *    - Si se envía `paginaDestino`, actualiza `paginaAnterior` y `paginaEnCurso`, y redirige.
 *
 * 3. Gestión del botón "Atrás" / cierre de sesión:
 *    - Si se envía `atras`, destruye la sesión actual, la reinicia y vuelve a la página anterior.
 *
 * 4. Preparación de datos del usuario (`$avInicioPrivado`):
 *    - Extrae de `$_SESSION['usuarioActualDWESLoginLogoff']`:
 *       - Código de usuario (`codUsuario`)
 *       - Número de conexiones (`numConexiones`)
 *       - Fecha y hora de la última conexión anterior (`fechaHoraUltimaConexionAnterior`)
 *       - Descripción del usuario (`descUsuario`)
 *
 * 5. Carga la vista principal (`layout`) con los datos preparados.
 *
 * Dependencias:
 * - Variables de sesión `$_SESSION`
 * - Clase `Usuario` para obtener información del usuario
 * - Arreglo `$view` para cargar la vista layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

if (!isset($_SESSION['usuarioActualDWESLoginLogoff'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'Detalle';
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['mantenimiento'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: indexLoginLogoff.php');
    exit;
}
if (isset($_REQUEST['rest'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError,null);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}

// Preparación de los datos del usuario para la vista
$avInicioPrivado = [
    "codUsuario" => $_SESSION['usuarioActualDWESLoginLogoff']->getCodUsuario(),
    "numConexiones" => $_SESSION['usuarioActualDWESLoginLogoff']->getNumConexiones(),
    "fechaHoraUltimaConexionAnterior" => $_SESSION['usuarioActualDWESLoginLogoff']->getFechaHoraUltimaConexionAnterior(),
    "descUsuario" => $_SESSION['usuarioActualDWESLoginLogoff']->getDescUsuario()
];

// Carga la vista layout principal
require_once $view["layout"];
