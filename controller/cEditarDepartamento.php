<?php

/**
 * Controlador: Modificación de Departamento
 *
 * Este controlador gestiona la visualización y edición de un departamento
 * previamente seleccionado.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Permite volver a la página anterior mediante el botón "Atrás".
 * - Obtiene el departamento seleccionado desde la sesión y la base de datos.
 * - Prepara los datos para la vista.
 * - Valida los campos del formulario al intentar cambiar datos:
 *      - descDepartamento (alfanumérico, 1-255 caracteres)
 *      - VolumenDeNegocio (float positivo)
 * - Si la validación es correcta, actualiza el departamento mediante
 *   `DepartamentoPDO::editarDepartamento` y redirige al mantenimiento.
 *
 * Dependencias:
 * - Clase `DepartamentoPDO`
 * - Clase `validacionFormularios`
 * - Variables de sesión `$_SESSION`
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

// Botón "Atrás" para regresar a mantenimiento
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'descDepartamento' => null,
    'VolumenDeNegocio' => null
];

$aRespuestas = [
    'descDepartamento' => '',
    'VolumenDeNegocio' => ''
];

$entradaOK = true;

$gestionDepartamentos = new DepartamentoPDO();

$codigoDepartamentoSeleccionado = $_SESSION['codDptoSeleccionado'];
$departamentoSeleccionado = $gestionDepartamentos->seleccionarDepartamento($codigoDepartamentoSeleccionado);
$_SESSION['dptoSeleccionado'] = $departamentoSeleccionado;

// Datos preparados para la vista
$datosDepartamentoVista = [
    "codDepartamento" => $departamentoSeleccionado->getCodDepartamento(),
    "descDepartamento" => $departamentoSeleccionado->getDescDepartamento(),
    "fechaCreacionDepartamento" => $departamentoSeleccionado->getFechaCreacionDepartamento(),
    "VolumenDeNegocio" => $departamentoSeleccionado->getVolumenDeNegocio(),
    "fechaBajaDepartamento" => $departamentoSeleccionado->getFechaBajaDepartamento()
];

// Procesamiento del formulario de edición
if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $descDepartamento = $_REQUEST['descDepartamento'];
    $volumenNegocio = $_REQUEST['VolumenDeNegocio'];

    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($descDepartamento, 255, 1, 1);
    $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenNegocio, PHP_FLOAT_MAX, 0, 1);

    $aRespuestas['descDepartamento'] = $descDepartamento;
    $aRespuestas['VolumenDeNegocio'] = $volumenNegocio;

    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $datosNuevos = [
            "T02_DescDepartamento" => $descDepartamento,
            "T02_VolumenDeNegocio" => $volumenNegocio
        ];

        $gestionDepartamentos->editarDepartamento($codigoDepartamentoSeleccionado, $datosNuevos);

        $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
        header('Location: index.php');
        exit;
    }

} else {
    $entradaOK = false;
}

require_once $view["layout"];
