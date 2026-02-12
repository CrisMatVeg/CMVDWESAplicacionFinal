<?php
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
