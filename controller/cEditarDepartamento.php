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
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

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

$departamentoPDO = new DepartamentoPDO();
$codDpto = $_SESSION['codDptoSeleccionado'];
$dptoSeleccionado = $departamentoPDO->seleccionarDepartamento($codDpto);
$_SESSION['dptoSeleccionado'] = $dptoSeleccionado;
$avConsultarDpto = [
    "codDepartamento" => $_SESSION['dptoSeleccionado']->getCodDepartamento(),
    "descDepartamento" => $_SESSION['dptoSeleccionado']->getDescDepartamento(),
    "fechaCreacionDepartamento" => $_SESSION['dptoSeleccionado']->getFechaCreacionDepartamento(),
    "VolumenDeNegocio" => $_SESSION['dptoSeleccionado']->getVolumenDeNegocio(),
    "fechaBajaDepartamento"=>$_SESSION['dptoSeleccionado']->getFechaBajaDepartamento()
];
if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['descDepartamento'],
        255,
        1,
        1
    );

    $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat(
        $_REQUEST['VolumenDeNegocio'],
        PHP_FLOAT_MAX,
        0,
        1
    );

    $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
    $aRespuestas['VolumenDeNegocio'] = $_REQUEST['VolumenDeNegocio'];

    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $datosNuevos = [
            "T02_DescDepartamento" => $_REQUEST['descDepartamento'],
            "T02_VolumenDeNegocio" => $_REQUEST['VolumenDeNegocio']
        ];
        $departamentoPDO->editarDepartamento($codDpto, $datosNuevos);
        $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
        header('Location: index.php');
        exit;
    }
} else {
    $entradaOK = false;
}

require_once $view["layout"];
