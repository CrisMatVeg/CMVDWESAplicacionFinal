<?php
/**
 * Endpoint API: Eliminación de usuario
 *
 * Este script gestiona la eliminación de un usuario mediante una petición HTTP
 * con formato JSON. Devuelve siempre una respuesta en formato JSON.
 *
 * Funcionalidad:
 * 1. Validación de acceso:
 *    - Recoge el parámetro `token` por GET.
 *    - Verifica su validez mediante `UsuarioPDO::validarToken`.
 *    - Si el token no es válido, devuelve error "No autorizado".
 *
 * 2. Recepción de datos:
 *    - Lee el cuerpo de la petición (JSON).
 *    - Requiere el campo `codUsuario`.
 *    - Requiere el campo `confirmacion`.
 *
 * 3. Validación funcional:
 *    - La confirmación debe ser exactamente "SI".
 *    - Si la validación falla, devuelve:
 *        - exito = false
 *        - array de errores
 *        - array de respuestas
 *
 * 4. Eliminación del usuario:
 *    - Llama al método `UsuarioPDO::borrarUsuario`.
 *    - Devuelve el resultado en formato JSON.
 *
 * Dependencias:
 * - Clase `UsuarioPDO`
 * - Métodos estáticos `validarToken` y `borrarUsuario`
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

$input = json_decode(file_get_contents('php://input'), true);

$aErrores = [
    'confirmacion' => null
];

$aRespuestas = [
    'confirmacion' => ''
];

$entradaOK = true;

if (!$input || !isset($input['codUsuario'])) {
    echo json_encode(['error' => 'Usuario no especificado']);
    exit;
}

if (!isset($input['confirmacion'])) {
    $aErrores['confirmacion'] = "Debe confirmar escribiendo SI";
    $entradaOK = false;
} else {
    $aRespuestas['confirmacion'] = $input['confirmacion'];

    $aErrores['confirmacion'] = $input['confirmacion'] === "SI" ? null : "Confirmación incorrecta";

    if ($aErrores['confirmacion'] !== null) {
        $entradaOK = false;
    }
}

if (!$entradaOK) {
    echo json_encode([
        'exito' => false,
        'errores' => $aErrores,
        'respuestas' => $aRespuestas
    ]);
    exit;
}

$eliminado = UsuarioPDO::borrarUsuario($input['codUsuario']);

echo json_encode([
    'exito' => $eliminado
]);
