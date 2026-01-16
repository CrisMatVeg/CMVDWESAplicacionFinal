<?php
/**
 * Controlador: Login (cLogin)
 *
 * Este controlador gestiona la lógica de inicio de sesión y navegación de la página de login
 * de la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * 1. Gestiona el botón "Cancelar"/"Atrás":
 *    - Si se envía el parámetro `atras`, actualiza la página actual
 *      a la página anterior y redirige a `indexLoginLogoff.php`.
 * 
 * 2. Gestiona el inicio de sesión:
 *    - Si se envía `paginaDestino = inicioPrivado`, recoge los valores
 *      de `codUsuario` y `password` del formulario.
 *    - Construye la contraseña combinando código de usuario y contraseña.
 *    - Llama al modelo `UsuarioPDO` para validar el usuario.
 *    - Si el usuario es válido:
 *       - Actualiza la última conexión en la base de datos y en el objeto usuario.
 *       - Almacena el usuario en la sesión (`usuarioActualDWESLoginLogoff`).
 *       - Actualiza la página en curso y redirige a `indexLoginLogoff.php`.
 *
 * Dependencias:
 * - Clase `UsuarioPDO` y sus métodos `validarUsuario` y `actualizarUltimaConexionYUsuario`
 * - Arreglo `$view` para cargar la vista final (`layout`)
 * - Variables de sesión `$_SESSION`
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */
 
// Gestión del botón "Atrás"/Cancelar
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: indexLoginLogoff.php');
    exit;
}

if (isset($_REQUEST['registro'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'Registro';
    header('Location: indexLoginLogoff.php');
    exit;
}

// Gestión del login hacia inicio privado
if (isset($_REQUEST['paginaDestino']) && $_REQUEST['paginaDestino'] == "inicioPrivado") {
    $codUsuario = $_REQUEST['codUsuario'] == null ? '' : $_REQUEST['codUsuario'];
    $password = $_REQUEST['password'] == null ? '' : $codUsuario . $_REQUEST['password'];

    // Llamar al modelo
    $usuarioPDO = new UsuarioPDO();
    $usuario = $usuarioPDO->validarUsuario($codUsuario, $password);

    if ($usuario != false) {
        $usuarioPDO->actualizarUltimaConexionYUsuario($usuario);
        $_SESSION['usuarioActualDWESLoginLogoff'] = $usuario;
        $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
        $_SESSION['paginaEnCurso'] = $_REQUEST["paginaDestino"];
        header('Location: indexLoginLogoff.php');
        exit;
    }
}

// Carga la vista layout principal
require_once $view['layout'];
