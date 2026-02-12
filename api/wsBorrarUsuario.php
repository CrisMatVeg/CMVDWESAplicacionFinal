<?php
require_once '../model/UsuarioPDO.php';

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

header('Content-Type: application/json');

$tokenAcceso = $_GET['token'] ?? null;

if (!$tokenAcceso || !UsuarioPDO::validarToken($tokenAcceso)) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$datosEntrada = json_decode(file_get_contents('php://input'), true);

if (!$datosEntrada || !isset($datosEntrada['codUsuario'])) {
    echo json_encode(['error' => 'Usuario no especificado']);
    exit;
}

$aErrores = [
    'confirmacion' => null
];

$aRespuestas = [
    'confirmacion' => ''
];

$entradaOK = true;

if (!isset($datosEntrada['confirmacion'])) {
    $aErrores['confirmacion'] = "Debe confirmar escribiendo SI";
    $entradaOK = false;
} else {
    $aRespuestas['confirmacion'] = $datosEntrada['confirmacion'];

    if ($datosEntrada['confirmacion'] !== "SI") {
        $aErrores['confirmacion'] = "Confirmación incorrecta";
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

$usuarioEliminado = UsuarioPDO::borrarUsuario($datosEntrada['codUsuario']);

echo json_encode([
    'exito' => $usuarioEliminado
]);
