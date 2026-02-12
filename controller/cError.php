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
    $avError = [
        'codError' => '',
        'descError' => '',
        'archivoError' => '',
        'lineaError' => '',
        'paginaSiguiente' => ''
    ];

    if(isset($_SESSION['error'])){
        $oError=$_SESSION['error'];
        $avError=[
            'codError'=>$oError->getCodError(),
            'descError'=>$oError->getDescError(),
            'archivoError'=>$oError->getArchivoError(),
            'lineaError'=>$oError->getLineaError(),
            'paginaSiguiente'=>$oError->getPaginaSiguiente()
        ];
        unset($_SESSION['error']);
    }

    if(isset($_REQUEST['atras'])){
        $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
        header('Location: index.php');
        exit;
    }
    require_once $view['layout'];
