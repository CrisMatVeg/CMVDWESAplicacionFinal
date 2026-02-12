<?php
/**
 * Controlador: API Externa
 *
 * Gestiona la visualización de la foto de la NASA y razas de perros.
 * Permite seleccionar fecha y raza, ampliar detalles y navegar entre páginas.
 *
 * Funcionalidad:
 * - Validación de sesión.
 * - Inicialización de fecha y raza si no existen en sesión.
 * - Navegación: ampliar detalles de NASA o Dog, o volver a la página anterior.
 * - Validación de entradas: fecha y raza seleccionada.
 * - Consumo de APIs externas:
 *      - NASA: obtiene la foto del día según la fecha seleccionada.
 *      - Dog API: obtiene la imagen y listado de razas.
 * - Guarda datos obtenidos en sesión para ser usados en la vista.
 *
 * Dependencias:
 * - Clases REST, NASA, DogApi
 * - Librería validacionFormularios
 * - Variables de sesión $_SESSION
 * - Arreglo $view para cargar la vista layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */

// Validar sesión
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Inicializar fecha de la foto NASA
if (!isset($_SESSION['fechaFotoNasa'])) {
    $fechaActual = new DateTime();
    $_SESSION['fechaFotoNasa'] = $fechaActual->format('Y-m-d');
}

// Inicializar raza de perro seleccionada
if (!isset($_SESSION['razaPerroSeleccionada'])) {
    $_SESSION['razaPerroSeleccionada'] = null;
}

// Navegación a detalles
if (isset($_REQUEST['ampliarnasa'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'DetallesNasa';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['ampliardog'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'DetallesDog';
    header('Location: index.php');
    exit;
}

// Botón Atrás
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Inicializar errores y respuestas
$aErrores = [
    'fecha' => null,
    'razas' => null
];

$aRespuestas = [
    'fecha' => '',
    'razas' => ''
];

$entradaOK = true;

// Validación de fecha o raza si se envió el formulario
if (isset($_REQUEST['enviarFecha']) || isset($_REQUEST['enviarRaza'])) {

    if (isset($_REQUEST['enviarFecha'])) {
        $aErrores['fecha'] = validacionFormularios::validarFecha(
            $_REQUEST['fecha'],
            date('Y-m-d'),
            '1995-06-16',
            1
        );
        $aRespuestas['fecha'] = $_REQUEST['fecha'];
    }

    if (isset($_REQUEST['enviarRaza'])) {
        $aErrores['razas'] = null;
        $aRespuestas['razas'] = $_REQUEST['razas'] ?? null;
    }

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        if (isset($_REQUEST['enviarFecha']) && !empty($_REQUEST['fecha'])) {
            $_SESSION['fechaFotoNasa'] = $_REQUEST['fecha'];
        }

        if (isset($_REQUEST['enviarRaza'])) {
            $_SESSION['razaPerroSeleccionada'] = $_REQUEST['razas'] ?: null;
        }
    }
} else {
    $entradaOK = false;
}

// Inicializar REST
$rest = new REST();

// Clave API de NASA
$claveApiNasa = 'aJQGMfgeU4awVVTZeZeGMd5f6584nCyFtm4Ud4h1';

// Obtener datos de NASA y crear objeto
$datosNasaApi = $rest->obtenerNasa($claveApiNasa, $_SESSION['fechaFotoNasa']);
$nasa = $datosNasaApi ? new NASA($datosNasaApi) : null;

// Obtener datos de Dog API y crear objeto
$datosPerroApi = $rest->obtenerPerro($_SESSION['razaPerroSeleccionada']);
$perro = $datosPerroApi ? new DogApi($datosPerroApi) : null;

// Obtener listado de razas
$datosRazasApi = $rest->obtenerRazasPerro();
$listadoRazas = DogApi::procesarRazas($datosRazasApi);

// Guardar resultados en sesión
$_SESSION['nasa'] = $nasa->obtenerDatosFotoNasa();
$_SESSION['perro'] = $perro->obtenerDatosFotoPerro();
$_SESSION['razas'] = $listadoRazas;

// Cargar layout
require_once $view["layout"];
