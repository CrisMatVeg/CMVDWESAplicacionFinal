<?php
/**
 * Endpoint API: Búsqueda de usuarios
 *
 * Permite consultar usuarios por descripción.
 * Requiere token válido.
 * Acepta método GET y POST.
 *
 * @package API
 * @author Cristian Mateos
 * @version 3.0
 */

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

require_once '../model/UsuarioPDO.php';
require_once '../model/Usuario.php';
require_once '../core/231018libreriaValidacion.php';

/* VALIDACIÓN DE MÉTODO */

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([], JSON_PRETTY_PRINT);
    exit;
}

/* VALIDACIÓN TOKEN */

$token = $_REQUEST['token'] ?? null;

if (empty($token) || !UsuarioPDO::validarToken($token)) {
    http_response_code(401);
    echo json_encode([], JSON_PRETTY_PRINT);
    exit;
}

/* VALIDACIÓN PARÁMETRO */

$descripcion = $_REQUEST['descripcion'] ?? '';

if (!is_string($descripcion)) {
    http_response_code(400);
    echo json_encode([], JSON_PRETTY_PRINT);
    exit;
}

$descripcion = trim($descripcion);

if (!empty($descripcion) &&
    !empty(validacionFormularios::comprobarAlfabetico($descripcion, 255, 0, 0))
) {
    http_response_code(400);
    echo json_encode([], JSON_PRETTY_PRINT);
    exit;
}

/* BÚSQUEDA USUARIOS */

$listaUsuarios = UsuarioPDO::buscarUsuarios($descripcion);

$resultado = [];

if (is_array($listaUsuarios)) {

    foreach ($listaUsuarios as $usuario) {

        if ($usuario instanceof Usuario) {

            $resultado[] = [
                'codUsuario' => $usuario->getCodUsuario(),
                'descUsuario' => $usuario->getDescUsuario(),
                'numConexiones' => $usuario->getNumConexiones(),
                'fechaHoraUltimaConexion' => $usuario->getFechaHoraUltimaConexion(),
                'perfil' => $usuario->getPerfil()
            ];
        }
    }
}

echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
