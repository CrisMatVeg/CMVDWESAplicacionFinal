<?php

/**
 * Controlador: Consultar Departamento
 *
 * Este controlador permite visualizar los datos de un departamento
 * previamente seleccionado en el mantenimiento de departamentos.
 *
 * Funcionalidad:
 * - Permite volver a la página anterior mediante el botón "atras".
 * - Obtiene el código del departamento almacenado en sesión.
 * - Recupera el departamento mediante `DepartamentoPDO::seleccionarDepartamento`.
 * - Almacena el objeto departamento en sesión.
 * - Prepara un array asociativo con los datos para la vista.
 *
 * Dependencias:
 * - Clase `DepartamentoPDO`
 * - Objeto Departamento y sus métodos getter
 * - Variable de sesión `codDptoSeleccionado`
 * - Arreglo `$view` para cargar el layout
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 2.0
 */

// Volver a la página anterior
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$gestionDepartamentos = new DepartamentoPDO();

$codigoDepartamentoSeleccionado = $_SESSION['codDptoSeleccionado'];

// Se obtiene el departamento seleccionado desde base de datos
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

require_once $view["layout"];
