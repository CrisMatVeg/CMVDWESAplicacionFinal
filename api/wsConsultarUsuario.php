<?php
require_once '../model/UsuarioPDO.php';

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
 * Códigos de respuesta:
 * - 401 → Token no válido o no autorizado.
 * - 400 → Usuario no especificado.
 * - 404 → Usuario no encontrado.
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

header('Content-Type: application/json');

$tokenAcceso = $_GET['token'] ?? null;

if (!$tokenAcceso || !UsuarioPDO::validarToken($tokenAcceso)) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Se obtiene el cuerpo JSON de la petición
$datosEntrada = json_decode(file_get_contents("php://input"), true);

if (!$datosEntrada || empty($datosEntrada['codUsuario'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Usuario no especificado']);
    exit;
}

$codigoUsuario = $datosEntrada['codUsuario'];

$usuarioEncontrado = UsuarioPDO::validarUsuario($codigoUsuario);

if (!$usuarioEncontrado) {
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
    exit;
}

echo json_encode([
    'codUsuario' => $usuarioEncontrado->getCodUsuario(),
    'descUsuario' => $usuarioEncontrado->getDescUsuario(),
    'numConexiones' => $usuarioEncontrado->getNumConexiones(),
    'fechaHoraUltimaConexion' => $usuarioEncontrado->getFechaHoraUltimaConexion(),
    'perfil' => $usuarioEncontrado->getPerfil()
], JSON_PRETTY_PRINT);
