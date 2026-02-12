<?php
/**
 * Endpoint API: Consulta de usuario por código
 *
 * Este script permite obtener la información completa de un usuario
 * a partir de su código, mediante una petición HTTP con cuerpo JSON.
 *
 * Funcionalidad:
 * - Valida el token recibido por GET.
 * - Lee el cuerpo de la petición en formato JSON.
 * - Comprueba que se haya enviado `codUsuario`.
 * - Verifica la existencia del usuario en base de datos.
 * - Devuelve los datos del usuario en formato JSON.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Métodos `validarToken` y `validarUsuario`
 * - Clase `Usuario` y sus métodos getter
 *
 * @package API
 * @author Cristian Mateos
 * @version 2.0
 */
require_once '../model/UsuarioPDO.php';
header('Content-Type: application/json');

$token = $_GET['token'] ?? null;

if (!$token || !UsuarioPDO::validarToken($token)) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$rawData = file_get_contents("php://input");
$input = json_decode($rawData, true);

if (!$input || !isset($input['codUsuario']) || empty($input['codUsuario'])) {
    echo json_encode(['error' => 'Usuario no especificado']);
    exit;
}

$codUsuario = $input['codUsuario'];

$usuario = UsuarioPDO::validarUsuario($codUsuario);

if (!$usuario) {
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
