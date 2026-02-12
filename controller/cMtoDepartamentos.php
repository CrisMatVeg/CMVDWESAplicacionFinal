<?php

/**
 * Controlador: Mantenimiento de Departamentos
 *
 * Este controlador gestiona la página de mantenimiento de departamentos en la aplicación.
 * Permite navegar, buscar, filtrar y realizar acciones sobre departamentos.
 *
 * Funcionalidad:
 * - Validación de sesión: si no hay usuario activo, redirige a Login.
 * - Navegación entre páginas:
 *      - Atrás / Volver: vuelve a la página anterior.
 *      - Ver / Editar / Eliminar / Dar de baja / Rehabilitar / Alta departamento.
 * - Búsqueda y filtrado:
 *      - Validación del campo de búsqueda (solo letras).
 *      - Guarda la búsqueda y estado seleccionado en sesión.
 * - Preparación de lista de departamentos según filtros y búsqueda.
 *
 * Dependencias:
 * - Clase `DepartamentoPDO` y métodos `buscarDepartamentos`, `bajaDepartamento`, `rehabilitarDepartamento`.
 * - Clase `validacionFormularios`.
 * - Variables de sesión `$_SESSION`.
 * - Arreglo `$view` para cargar la vista layout.
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
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

$departamentoPDO = new DepartamentoPDO();

// Acciones de mantenimiento
if (isset($_REQUEST['verDpto'], $_REQUEST['codDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['codDptoSeleccionado'] = $_REQUEST['codDpto'];
    $_SESSION['paginaEnCurso'] = 'ConsultarDepartamentos';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editarDpto'], $_REQUEST['codDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['codDptoSeleccionado'] = $_REQUEST['codDpto'];
    $_SESSION['paginaEnCurso'] = 'EditarDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaDpto'], $_REQUEST['codDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $departamentoPDO->bajaDepartamento($_REQUEST['codDpto']);
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['altaDpto'], $_REQUEST['codDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $departamentoPDO->rehabilitarDepartamento($_REQUEST['codDpto']);
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarDpto'], $_REQUEST['codDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['codDptoSeleccionado'] = $_REQUEST['codDpto'];
    $_SESSION['paginaEnCurso'] = 'EliminarDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['newdpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'AltaDepartamento';
    header('Location: index.php');
    exit;
}

// Inicialización de búsqueda
$entradaOK = true;
$aErrores = ['descripcion' => ''];
$aRespuestas = ['descripcion' => ''];

// Recuperar búsqueda previa
if (isset($_SESSION['busquedaDepartamento'])) {
    $aRespuestas['descripcion'] = $_SESSION['busquedaDepartamento'];
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
        $_SESSION['busquedaDepartamento'] = $descripcion;
    }
}

// Estado del filtro
$estadoSeleccionado = $_REQUEST['estado'] ?? $_SESSION['estadoDepartamento'] ?? 'Todos';
$_SESSION['estadoDepartamento'] = $estadoSeleccionado;

// Obtener lista de departamentos según búsqueda y estado
$descripcionBusqueda = $_SESSION['busquedaDepartamento'] ?? null;
$departamentos = $departamentoPDO->buscarDepartamentos($estadoSeleccionado, $descripcionBusqueda);

// Cargar vista
require_once $view["layout"];
