<?php

/**
 * Controlador: Añadir Departamento
 *
 * Este controlador gestiona la creación de nuevos departamentos
 * en la aplicación final.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Gestiona el botón "Atrás" hacia el mantenimiento de departamentos.
 * - Valida los datos del formulario:
 *      - codDepartamento (3 caracteres alfanuméricos)
 *      - descDepartamento (4-255 caracteres)
 *      - VolumenDeNegocio (float positivo)
 * - Comprueba que el código de departamento no exista.
 * - Crea el departamento mediante `DepartamentoPDO::altaDepartamento`.
 * - Redirige a mantenimiento si el alta es correcta.
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

// Gestión del botón atrás
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'codDepartamento' => null,
    'descDepartamento' => null,
    'VolumenDeNegocio' => null
];

$aRespuestas = [
    'codDepartamento' => '',
    'descDepartamento' => '',
    'VolumenDeNegocio' => ''
];

$entradaOK = true;

if (isset($_REQUEST['confirmarAñadir'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $codigoDepartamento = $_REQUEST['codDepartamento'];
    $descripcionDepartamento = $_REQUEST['descDepartamento'];
    $volumenNegocio = $_REQUEST['VolumenDeNegocio'];

    // Validación de campos
    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfaNumerico($codigoDepartamento, 3, 3, 1);
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($descripcionDepartamento, 255, 4, 1, 1);
    $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat($volumenNegocio, PHP_FLOAT_MAX, 0, 1);

    $aRespuestas['codDepartamento'] = $codigoDepartamento;
    $aRespuestas['descDepartamento'] = $descripcionDepartamento;
    $aRespuestas['VolumenDeNegocio'] = $volumenNegocio;

    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {

        // Verifica si el código ya existe
        if (DepartamentoPDO::validarCodNoExiste($codigoDepartamento)) {
            $aErrores['codDepartamento'] = "El codigo de departamento ya existe.";
            $entradaOK = false;
        } else {

            $departamentoCreado = DepartamentoPDO::altaDepartamento(
                $codigoDepartamento,
                $descripcionDepartamento,
                $volumenNegocio
            );

            if ($departamentoCreado === null) {
                $entradaOK = false;
                $_SESSION['errorRegistro'] = "Error al crear el departamento. Por favor, inténtalo de nuevo.";
            } else {
                $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
                header('Location: index.php');
                exit;
            }
        }
    }
} else {
    $entradaOK = false;
}

require_once $view['layout'];
