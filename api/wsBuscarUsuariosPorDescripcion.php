<?php
/**
 * Endpoint API: Búsqueda de usuarios
 *
 * Este script gestiona la consulta de usuarios mediante una petición HTTP
 * y devuelve los resultados en formato JSON.
 *
 * Funcionalidad:
 * 1. Validación de acceso:
 *    - Recoge el parámetro `token` por GET.
 *    - Verifica su validez mediante `UsuarioPDO::validarToken`.
 *    - Si el token no es válido, devuelve error "Token no valido".
 *
 * 2. Búsqueda de usuarios:
 *    - Recoge el parámetro opcional `descripcion`.
 *    - Llama al método `UsuarioPDO::buscarUsuarios`.
 *    - Obtiene una colección de objetos Usuario.
 *
 * 3. Formateo de respuesta:
 *    - Recorre la lista de usuarios.
 *    - Extrae los datos necesarios mediante métodos getter.
 *    - Devuelve el resultado en formato JSON estructurado.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Métodos estáticos `validarToken` y `buscarUsuarios`
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