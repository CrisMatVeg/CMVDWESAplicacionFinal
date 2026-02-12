<?php

/**
 * Controlador: Mantenimiento de Usuarios
 *
 * Este controlador gestiona la página de mantenimiento de usuarios en la aplicación.
 * Permite navegar, buscar, filtrar y realizar acciones sobre usuarios.
 *
 * Funcionalidad:
 * - Validación de sesión: si no hay usuario activo, redirige a Login.
 * - Navegación entre páginas:
 *      - Atrás / Volver: vuelve a la página anterior.
 *      - Ver / Editar / Eliminar / Baja de usuario.
 * - Búsqueda y filtrado:
 *      - Validación del campo de búsqueda (solo letras, sin números).
 *      - Guarda la búsqueda en sesión.
 * - Preparación de lista de usuarios según la búsqueda.
 *
 * Dependencias:
 * - Clase `UsuarioPDO` y métodos `seleccionarUsuario`, `buscarUsuarios`.
 * - Clase `validacionFormularios`.
 * - Variables de sesión `$_SESSION`.
 * - Arreglo `$view` para cargar la vista layout.
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

// Control de sesión
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Navegación
if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$usuarioPDO = new UsuarioPDO();

// Acciones de mantenimiento
if (isset($_REQUEST['verUsuario'], $_REQUEST['codUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['codUsuarioSeleccionado'] = $_REQUEST['codUsuario'];
    $_SESSION['paginaEnCurso'] = 'ConsultarUsuario';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editarUsuario'], $_REQUEST['codUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codUsuario = $_REQUEST['codUsuario'];
    $_SESSION['codUsuarioSeleccionado'] = $codUsuario;
    $_SESSION['usuarioSeleccionado'] = $usuarioPDO->seleccionarUsuario($codUsuario);
    $_SESSION['paginaEnCurso'] = 'EditarUsuario';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'WIP'; // Funcionalidad pendiente
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarUsuario'], $_REQUEST['codUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['codUsuarioSeleccionado'] = $_REQUEST['codUsuario'];
    $_SESSION['paginaEnCurso'] = 'EliminarUsuario';
    header('Location: index.php');
    exit;
}

// Inicialización de búsqueda
$entradaOK = true;
$aErrores = ['descripcion' => ''];
$aRespuestas = ['descripcion' => ''];

// Recuperar búsqueda previa
if (isset($_SESSION['busquedaUsuario'])) {
    $aRespuestas['descripcion'] = $_SESSION['busquedaUsuario'];
}

// Procesamiento del formulario de búsqueda
if (isset($_REQUEST['enviar'])) {
    $descripcion = $_REQUEST['descripcion'] ?? '';
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($descripcion, 255, 1, 0);

    // Validar que no contenga números
    if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $descripcion)) {
        $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
    }

    $aRespuestas['descripcion'] = $descripcion;

    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $_SESSION['busquedaUsuario'] = $descripcion;
    }
}

// Lista de usuarios según búsqueda
$usuarios = $entradaOK && !empty($_SESSION['busquedaUsuario'])
    ? $usuarioPDO->buscarUsuarios($_SESSION['busquedaUsuario'])
    : $usuarioPDO->buscarUsuarios();

// Cargar vista
require_once $view["layout"];
