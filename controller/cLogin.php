<?php
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = 'inicioPublico';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['registro'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'Registro';
    header('Location: index.php');
    exit;
}

$aErrores = [
    'codUsuario' => null,
    'password' => null
];

$aRespuestas = [
    'codUsuario' => '',
    'password' => ''
];

$entradaOK = true;

if (isset($_REQUEST['acceder'])) {

    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];

    // Validaciones usando la librería
    $aErrores['codUsuario'] = validacionFormularios::comprobarAlfaNumerico(
        $_REQUEST['codUsuario'],
        10,
        4,
        1
    );

    $aErrores['password'] = validacionFormularios::validarPassword(
        $_REQUEST['password'],
        10,
        4,
        1,
        1
    );

    // Guardar respuestas
    $aRespuestas['codUsuario'] = $_REQUEST['codUsuario'];
    $aRespuestas['password'] = $_REQUEST['password'];

    // Comprobar si hay errores
    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {

        $codUsuario = $_REQUEST['codUsuario'];
        $password = $codUsuario . $_REQUEST['password'];

        // Llamar al modelo
        $usuarioPDO = new UsuarioPDO();
        $usuario = $usuarioPDO->validarUsuario($codUsuario, $password);

        if ($usuario != false) {
            $usuarioPDO->actualizarUltimaConexionYUsuario($usuario);
            $_SESSION['usuarioActualDWESAplicacionFinal'] = $usuario;
            $_SESSION['paginaEnCurso'] = 'inicioPrivado';
            header('Location: index.php');
            exit;
        }
    }
} else {
    // Si no se ha enviado el formulario
    $entradaOK = false;
}

require_once $view['layout'];
