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
 * @author Cristian Mateos Vega
 * @version 2.0
 */

// Control de sesión obligatoria
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

// Cierre completo de sesión
if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();

    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];

    header('Location: index.php');
    exit;
}

// Volver a zona privada
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

    $passwordActual = $_REQUEST['passwordactual'];
    $passwordNueva = $_REQUEST['passwordnueva'];
    $confirmacionPasswordNueva = $_REQUEST['confirmarpasswordnueva'];

    // Validación de formato de contraseñas
    $aErrores['passwordactual'] = validacionFormularios::validarPassword($passwordActual, 8, 4, 1, 1);
    $aErrores['passwordnueva'] = validacionFormularios::validarPassword($passwordNueva, 8, 4, 1, 1);
    $aErrores['confirmarpasswordnueva'] = validacionFormularios::validarPassword($confirmacionPasswordNueva, 8, 4, 1, 1);

    $aRespuestas['passwordactual'] = $passwordActual;
    $aRespuestas['passwordnueva'] = $passwordNueva;
    $aRespuestas['confirmarpasswordnueva'] = $confirmacionPasswordNueva;

    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {

        $usuarioActual = $_SESSION['usuarioActualDWESAplicacionFinal'];

        // Se calcula el hash de la contraseña actual introducida
        $passwordActualHasheada = hash('sha256', $usuarioActual->getCodUsuario() . $passwordActual);

        if ($usuarioActual->getPassword() !== $passwordActualHasheada) {
            $aErrores['passwordactual'] = "La contraseña actual no es correcta.";
            $entradaOK = false;
        }

        if ($passwordNueva !== $confirmacionPasswordNueva) {
            $aErrores['confirmarpasswordnueva'] = "Las nuevas contraseñas no coinciden.";
            $entradaOK = false;
        }
    }

    if ($entradaOK) {

        $usuarioActualizado = UsuarioPDO::cambiarPassword(
            $usuarioActual,
            $passwordNueva
        );

        if ($usuarioActualizado !== null) {
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuarioActualizado;
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
