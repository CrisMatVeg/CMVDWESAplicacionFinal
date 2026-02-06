<?php
session_start();
require_once '../model/UsuarioPDO.php';
header('Content-Type: application/json');
define('API_KEY', 'apikey1234');

if (!isset($_SESSION['usuarioActualDWESAplicacionFinal'])) {
    echo json_encode(['sesion_iniciada'=>false]);
    exit;
}

$token = $_GET['token'] ?? null;

if ($token !== API_KEY) {
    echo json_encode(['error_de_token' => 'Acceso no autorizado']);
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