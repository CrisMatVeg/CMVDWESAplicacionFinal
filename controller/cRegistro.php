<?php
/**
 * Controlador: Registro
 *
 * Este controlador gestiona el registro de nuevos usuarios en la aplicación Login/Logoff.
 *
 * Funcionalidad:
 * - Navegación:
 *      - Atrás: vuelve a la página anterior.
 * - Registro de usuario:
 *      - Valida campos: código de usuario, contraseña, descripción y pregunta de seguridad.
 *      - Comprueba si el código de usuario ya existe.
 *      - Si no existe, crea el usuario y redirige a inicio privado.
 *      - Si ocurre un error, guarda el mensaje en sesión y redirige a login.
 *
 * Dependencias:
 * - Clase `UsuarioPDO` para operaciones sobre usuarios.
 * - Constante `RESPUESTA_SEGURIDAD` para validar la pregunta de seguridad.
 * - Variables de sesión `$_SESSION`.
 * - Arreglo `$view` para cargar la vista `layout`.
 *
 * @package Controladores
 * @author Cristian Mateos
 * @version 1.0
 */
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$aErrores = [
    'codUsuario' => null,
    'password' => null,
    'descUsuario' => null,
    'preguntaSeguridad' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => '',
    'descUsuario' => '',
    'preguntaSeguridad' => ''
];

$entradaOK = true;

if (isset($_REQUEST['acceso'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['codUsuario'], 10, 4, 1);
    $aErrores['password'] = validacionFormularios::validarPassword($_REQUEST['password'], 10, 4, 1, 1);
    $aErrores['descUsuario'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descUsuario'], 255, 4, 1);
    $aErrores['preguntaSeguridad'] = $_REQUEST['preguntaSeguridad']===RESPUESTA_SEGURIDAD ? null : "La respuesta no es correcta";

    $aRespuestas['codUsuario'] = $_REQUEST['codUsuario'];
    $aRespuestas['password'] = $_REQUEST['password'];
    $aRespuestas['descUsuario'] = $_REQUEST['descUsuario'];
    $aRespuestas['preguntaSeguridad'] = $_REQUEST['preguntaSeguridad'];

    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Se comprueba si el código de usuario ya existe
        if (UsuarioPDO::validarCodNoExiste($_REQUEST['codUsuario'])) {
            $aErrores['codUsuario'] = "El nombre de usuario ya existe.";
            $entradaOK = false;
        } else {
            // Si no existe, se crea el nuevo usuario
            $passwordConcatenada = $_REQUEST['codUsuario'] . $_REQUEST['password'];
            $oUsuario = UsuarioPDO::altaUsuario(
                $_REQUEST['codUsuario'],
                $passwordConcatenada,
                $_REQUEST['descUsuario']
            );


            if ($oUsuario === null) {
                $entradaOK = false;
                //Se crea el error en el caso de que no se pueda crear el usuario
                $_SESSION['errorRegistro'] = "Error al crear el usuario. Por favor, inténtalo de nuevo.";
                //Se redirige al login 
                $_SESSION['paginaEnCurso'] = 'Login';
                header('Location: index.php');
                exit;
            } else {
                // Login correcto
                $_SESSION['usuarioActualDWESAplicacionFinal'] = $oUsuario;
                $_SESSION['paginaEnCurso'] = 'inicioPrivado';
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