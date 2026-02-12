<?php

/**
 * Controlador: Modificación de Usuario (actualmente no activo, no funcional con API)
 *
 * Este controlador gestiona la visualización y edición de un usuario
 * previamente seleccionado en el mantenimiento de usuarios.
 *
 * Funcionalidad:
 * - Verifica que exista sesión activa.
 * - Permite volver a la página de mantenimiento de usuarios mediante "Atrás".
 * - Obtiene el usuario seleccionado desde sesión y base de datos.
 * - Prepara los datos del usuario para la vista.
 * - Valida los campos del formulario al intentar cambiar datos:
 *      - DescUsuario (alfanumérico, 1-255 caracteres)
 *      - Perfil (alfanumérico, 1-10 caracteres)
 * - Si la validación es correcta, actualiza el usuario mediante
 *   `UsuarioPDO::editarUsuario` y redirige al mantenimiento.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
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

// Botón "Atrás" para volver al mantenimiento de usuarios
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'DescUsuario' => null,
    'Perfil' => null,
    'passwordactual' => null,
    'passwordnueva' => null
];

$aRespuestas = [
    'DescUsuario' => '',
    'Perfil' => '',
    'passwordactual' => '',
    'passwordnueva' => ''
];

$entradaOK = true;

$gestionUsuarios = new UsuarioPDO();
$codigoUsuarioSeleccionado = $_SESSION['codUsuarioSeleccionado'];

// Obtener el usuario seleccionado
$usuarioSeleccionado = $gestionUsuarios->validarUsuario($codigoUsuarioSeleccionado);
$_SESSION['usuarioSeleccionado'] = $usuarioSeleccionado;

// Procesamiento del formulario de edición
if (isset($_REQUEST['cambiarDatos'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $descUsuario = $_REQUEST['DescUsuario'];
    $perfilUsuario = $_REQUEST['Perfil'];

    $aErrores['DescUsuario'] = validacionFormularios::comprobarAlfaNumerico($descUsuario, 255, 1, 1);
    $aErrores['Perfil'] = validacionFormularios::comprobarAlfaNumerico($perfilUsuario, 10, 1, 1);

    $aRespuestas['DescUsuario'] = $descUsuario;
    $aRespuestas['Perfil'] = $perfilUsuario;

    foreach ($aErrores as $error) {
        if ($error !== null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        $datosNuevos = [
            "T01_DescUsuario" => $descUsuario,
            "T01_Perfil" => $perfilUsuario
        ];

        $gestionUsuarios->editarUsuario($codigoUsuarioSeleccionado, $datosNuevos);

        $_SESSION['paginaEnCurso'] = 'MtoUsuariosAPI';
        header('Location: index.php');
        exit;
    }

} else {
    $entradaOK = false;
}

require_once $view["layout"];
