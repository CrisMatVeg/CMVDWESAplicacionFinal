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
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
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

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$departamentoPDO = new DepartamentoPDO();

if (isset($_REQUEST['verDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'ConsultarDepartamentos';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editarDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'EditarDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $departamentoPDO->bajaDepartamento($codDpto);
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['altaDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $departamentoPDO->rehabilitarDepartamento($codDpto);
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarDpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codDpto = $_REQUEST['codDpto'];
    $_SESSION['codDptoSeleccionado'] = $codDpto;
    $_SESSION['paginaEnCurso'] = 'EliminarDepartamento';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['newdpto'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];;
    $_SESSION['paginaEnCurso'] = 'AltaDepartamento';
    header('Location: index.php');
    exit;
}

$entradaOK = true;
$aErrores = [
    'descripcion' => '',
];
$aRespuestas = [
    'descripcion' => '',
];

// Si ya hay búsqueda previa guardada en sesión, rellenamos $aRespuestas
if (isset($_SESSION['busquedaDepartamento'])) {
    $aRespuestas['descripcion'] = $_SESSION['busquedaDepartamento'];
}

if (isset($_REQUEST['enviar'])) {
    // Validamos el campo
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 0);
    if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $_REQUEST['descripcion'])) {
        $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
    }

    // Comprobamos si hubo errores
    foreach ($aErrores as $campo => $valor) {
        if ($valor != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Guardamos en sesión
        $_SESSION['busquedaDepartamento'] = $_REQUEST['descripcion'];
    }
}

$estadoSeleccionado = $_REQUEST['estado'] ?? 'Todos';

// Guardar estado en sesión
if (isset($_REQUEST['enviar'])) {
    $_SESSION['estadoDepartamento'] = $estadoSeleccionado;
} else {
    $estadoSeleccionado = $_SESSION['estadoDepartamento'] ?? 'Todos';
}

$descripcionBusqueda = $_SESSION['busquedaDepartamento'] ?? null;

$departamentos = $departamentoPDO->buscarDepartamentos(
    $estadoSeleccionado,
    $descripcionBusqueda
);

require_once $view["layout"];
