<?php
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

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
    'VolumenDeNegocio' => '',
];

$entradaOK = true;

if (isset($_REQUEST['confirmarAñadir'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['codDepartamento'], 3, 3, 1);
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descDepartamento'], 255, 4, 1, 1);
    $aErrores['VolumenDeNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['VolumenDeNegocio'], PHP_FLOAT_MAX, 0, 1);

    $aRespuestas['codDepartamento'] = $_REQUEST['codDepartamento'];
    $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
    $aRespuestas['VolumenDeNegocio'] = $_REQUEST['VolumenDeNegocio'];

    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Se comprueba si el código de departamento ya existe
        if (DepartamentoPDO::validarCodNoExiste($_REQUEST['codDepartamento'])) {
            $aErrores['codDepartamento'] = "El codigo de departamento ya existe.";
            $entradaOK = false;
        } else {
            // Si no existe, se crea el nuevo departamento
            $oDepartamento = DepartamentoPDO::altaDepartamento(
                $_REQUEST['codDepartamento'],
                $_REQUEST['descDepartamento'],
                $_REQUEST['VolumenDeNegocio']
            );


            if ($oDepartamento === null) {
                $entradaOK = false;
                //Se crea el error en el caso de que no se pueda crear el departamento
                $_SESSION['errorRegistro'] = "Error al crear el departamento. Por favor, inténtalo de nuevo.";
            } else {
                $_SESSION['paginaEnCurso'] = 'MtoDepartamentos';
                header('Location: index.php');
                exit;
            }
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}

// Si hay errores o no se ha enviado, cargar el layout con el formulario
require_once $view['layout'];
