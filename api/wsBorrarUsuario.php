<?php
session_start();
require_once '../model/UsuarioPDO.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    echo json_encode([]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input && isset($input['codUsuario'])) {
    $_SESSION['codUsuarioSeleccionado'] = $input['codUsuario'];
    $_SESSION['usuarioSeleccionado'] = UsuarioPDO::validarUsuario($input['codUsuario']);
    $_SESSION['paginaEnCurso'] = 'EliminarUsuario';
    echo json_encode(['status'=>'ok']);
}