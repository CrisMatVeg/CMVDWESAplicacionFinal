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
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
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
require_once $view["layout"];