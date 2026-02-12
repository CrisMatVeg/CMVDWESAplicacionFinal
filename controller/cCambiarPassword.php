<?php
/**
 * Controlador: Cambio de contraseña
 *
 * Este controlador permite al usuario autenticado modificar su contraseña.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Permite cerrar sesión mediante el botón "atras".
 * - Permite volver a la página privada mediante el botón "volver".
 * - Valida:
 *      - Contraseña actual
 *      - Nueva contraseña
 *      - Confirmación de nueva contraseña
 * - Comprueba que:
 *      - La contraseña actual sea correcta.
 *      - Las nuevas contraseñas coincidan.
 * - Actualiza la contraseña mediante `UsuarioPDO::cambiarPassword`.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Clase `validacionFormularios`
 * - Objeto usuario almacenado en sesión
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
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPrivado';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'passwordactual' => null,
    'passwordnueva' => null,
    'confirmarpasswordnueva' => null
];

$aRespuestas = [
    'passwordactual' => '',
    'passwordnueva' => '',
    'confirmarpasswordnueva' => ''
];

$entradaOK = true;

if (isset($_REQUEST['enviar'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['passwordactual'] = validacionFormularios::validarPassword($_REQUEST['passwordactual'], 8, 4, 1, 1);
    $aErrores['passwordnueva'] = validacionFormularios::validarPassword($_REQUEST['passwordnueva'], 8, 4, 1, 1);
    $aErrores['confirmarpasswordnueva'] = validacionFormularios::validarPassword($_REQUEST['confirmarpasswordnueva'], 8, 4, 1, 1);

    $aRespuestas['passwordactual'] = $_REQUEST['passwordactual'];
    $aRespuestas['passwordnueva'] = $_REQUEST['passwordnueva'];
    $aRespuestas['confirmarpasswordnueva'] = $_REQUEST['confirmarpasswordnueva'];

    foreach ($aErrores as $valorCampo => $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) { 
        $oUsuarioActual = $_SESSION['usuarioActualDWESAplicacionFinal'];

        $passwordActualHasheada = hash('sha256', $oUsuarioActual->getCodUsuario() . $_REQUEST['passwordactual']);

        if ($oUsuarioActual->getPassword() !== $passwordActualHasheada) {
            $aErrores['passwordactual'] = "La contraseña actual no es correcta.";
            $entradaOK = false;
        }

        if ($_REQUEST['passwordnueva'] !== $_REQUEST['confirmarpasswordnueva']) {
            $aErrores['confirmarpasswordnueva'] = "Las nuevas contraseñas no coinciden.";
            $entradaOK = false;
        } 
        
    }
    if ($entradaOK) {
        $oUsuarioModificado = UsuarioPDO::cambiarPassword(
            $_SESSION['usuarioActualDWESAplicacionFinal'], 
            $_REQUEST['passwordnueva']
        );
        if ($oUsuarioModificado != null) {
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $oUsuarioModificado; 
            $_SESSION['paginaEnCurso'] = 'MiCuenta';
            header('Location: index.php');
            exit;
        } else {
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false;
}
require_once $view['layout'];