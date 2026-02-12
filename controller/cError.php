<?php

/**
 * Controlador: Gestión de Errores
 *
 * Este controlador gestiona la visualización de errores en la aplicación.
 *
 * Funcionalidad:
 * - Comprueba si existe un objeto de error en sesión (`$_SESSION['error']`).
 * - Si existe, extrae la información del error:
 *      - Código
 *      - Descripción
 *      - Archivo
 *      - Línea
 *      - Página siguiente
 * - Permite volver a la página anterior mediante el botón "atras".
 * - Carga la vista de error (`layout`) con los datos preparados.
 *
 * Dependencias:
 * - Objeto Error almacenado en sesión y sus métodos getter
 * - Variables de sesión `$_SESSION`
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

// Inicialización de los datos de error
$datosError = [
    'codError' => '',
    'descError' => '',
    'archivoError' => '',
    'lineaError' => '',
    'paginaSiguiente' => ''
];

// Recupera el error desde sesión si existe
if (isset($_SESSION['error'])) {
    $errorSesion = $_SESSION['error'];

    $datosError = [
        'codError' => $errorSesion->getCodError(),
        'descError' => $errorSesion->getDescError(),
        'archivoError' => $errorSesion->getArchivoError(),
        'lineaError' => $errorSesion->getLineaError(),
        'paginaSiguiente' => $errorSesion->getPaginaSiguiente()
    ];

    unset($_SESSION['error']);
}

// Botón "Atrás" para volver a la página anterior
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

// Carga la vista de error
require_once $view['layout'];
