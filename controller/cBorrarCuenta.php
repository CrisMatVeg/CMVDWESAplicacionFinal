<?php

/**
 * Controlador: Baja de usuario
 *
 * Este controlador gestiona la eliminación del usuario actualmente
 * autenticado en la aplicación.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Permite volver a la página anterior mediante el botón "volver".
 * - Solicita confirmación escribiendo exactamente "SI".
 * - Si la confirmación es correcta:
 *      - Obtiene el código del usuario desde la sesión.
 *      - Elimina el usuario mediante `UsuarioPDO::borrarUsuario`.
 *      - Redirige a la página de inicio público.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Objeto usuario almacenado en sesión
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

// Gestión del botón volver
if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'confirmacion' => null
];

$aRespuestas = [
    'confirmacion' => ''
];

$entradaOK = true;

$gestionUsuarios = new UsuarioPDO();

if (isset($_REQUEST['confirmar'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $confirmacionUsuario = $_REQUEST['confirmacion'] ?? '';

    $aRespuestas['confirmacion'] = $confirmacionUsuario;

    // La confirmación debe ser exactamente "SI"
    if ($confirmacionUsuario !== "SI") {
        $aErrores['confirmacion'] = "Confirmación incorrecta";
        $entradaOK = false;
    }

    if ($entradaOK) {
        $codigoUsuario = $_SESSION['usuarioActualDWESAplicacionFinal']->getCodUsuario();
        $gestionUsuarios->borrarUsuario($codigoUsuario);

        $_SESSION['paginaEnCurso'] = 'inicioPublico';
        header('Location: index.php');
        exit;
    }

} else {
    $entradaOK = false;
}

require_once $view["layout"];
