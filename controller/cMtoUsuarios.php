<?php
if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    $_SESSION['paginaEnCurso'] = 'Login';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['atras'])) {
    session_unset();
    session_destroy();
    session_start();
    /* UsuarioPDO::guardarToken($codUsuario, null); */
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['volver'])) {
    $_SESSION['paginaAnterior'] = $_REQUEST['paginaAnterior'];
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}

$usuarioPDO = new UsuarioPDO();

if (isset($_REQUEST['verUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codUsuario = $_REQUEST['codUsuario'];
    $_SESSION['codUsuarioSeleccionado'] = $codUsuario;
    $_SESSION['paginaEnCurso'] = 'ConsultarUsuario';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['editarUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codUsuario = $_REQUEST['codUsuario'];
    $_SESSION['codUsuarioSeleccionado'] = $codUsuario;
    $usuarioSeleccionado= $usuarioPDO->seleccionarUsuario($codUsuario);
    $_SESSION['usuarioSeleccionado'] = $usuarioSeleccionado;
    $_SESSION['paginaEnCurso'] = 'EditarUsuario';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['bajaUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
/*     $codUsuario = $_REQUEST['codUsuario'];
    $_SESSION['codUsuarioSeleccionado'] = $codUsuario; */
    $_SESSION['paginaEnCurso'] = 'WIP';
    header('Location: index.php');
    exit;
}

if (isset($_REQUEST['borrarUsuario'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $codUsuario = $_REQUEST['codUsuario'];
    $_SESSION['codUsuarioSeleccionado'] = $codUsuario;
    $_SESSION['paginaEnCurso'] = 'EliminarUsuario';
    header('Location: index.php');
    exit;
}

$entradaOK = true;
$aErrores = [
    'descripcion' => '',
];
$aRespuestas = [
    'descripcion' => '',
];

// Si ya hay búsqueda previa guardada en sesión, rellenamos $aRespuestas
if (isset($_SESSION['busquedaUsuario'])) {
    $aRespuestas['descripcion'] = $_SESSION['busquedaUsuario'];
}

if (isset($_REQUEST['enviar'])) {
    // Validamos el campo
    $aErrores['descripcion'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 255, 1, 0);
    if (empty($aErrores['descripcion']) && preg_match('/[0-9]/', $_REQUEST['descripcion'])) {
        $aErrores['descripcion'] = 'El campo solo puede contener letras (sin números).';
    }

    // Comprobamos si hubo errores
    foreach ($aErrores as $campo => $valor) {
        if ($valor != null) {
            $entradaOK = false;
        }
    }

    if ($entradaOK) {
        // Guardamos en sesión
        $_SESSION['busquedaUsuario'] = $_REQUEST['descripcion'];
    }
}

// Llamar al modelo
if ($entradaOK && !empty($_SESSION['busquedaUsuario'])) {
    $usuarios = $usuarioPDO->buscarUsuarios($_SESSION['busquedaUsuario']);
} else {
    $usuarios = $usuarioPDO->buscarUsuarios();
}

require_once $view["layout"];
