<?php
require_once '../model/UsuarioPDO.php';
header('Content-Type: application/json');

$token = $_GET['token'] ?? null;

if (!$token || !UsuarioPDO::validarToken($token)) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$rawData = file_get_contents("php://input");
$input = json_decode($rawData, true);

if (!$input || !isset($input['codUsuario']) || empty($input['codUsuario'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Usuario no especificado']);
    exit;
}

$codUsuario = $input['codUsuario'];

$usuario = UsuarioPDO::validarUsuario($codUsuario);

if (!$usuario) {
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

echo json_encode([
    'codUsuario' => $usuario->getCodUsuario(),
    'descUsuario' => $usuario->getDescUsuario(),
    'numConexiones' => $usuario->getNumConexiones(),
    'fechaHoraUltimaConexion' => $usuario->getFechaHoraUltimaConexion(),
    'perfil' => $usuario->getPerfil()
], JSON_PRETTY_PRINT);
