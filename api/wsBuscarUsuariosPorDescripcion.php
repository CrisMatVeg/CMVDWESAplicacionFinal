<?php
require_once '../model/UsuarioPDO.php';
header('Content-Type: application/json');

$token = $_GET['token'] ?? null;

// Validar token
if (!$token || !UsuarioPDO::validarToken($token)) {
    http_response_code(401);
    echo json_encode(['error' => 'Token no valido']);
    exit;
}

$descripcion = $_GET['descripcion'] ?? null;
$listaUsuarios = UsuarioPDO::buscarUsuarios($descripcion);

$resultado = [];

foreach ($listaUsuarios as $usuario) {
    $resultado[] = [
        'codUsuario' => $usuario->getCodUsuario(),
        'descUsuario' => $usuario->getDescUsuario(),
        'numConexiones' => $usuario->getNumConexiones(),
        'fechaHoraUltimaConexion' => $usuario->getFechaHoraUltimaConexion(),
        'perfil' => $usuario->getPerfil()
    ];
}

echo json_encode($resultado, JSON_PRETTY_PRINT);