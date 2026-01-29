<?php
class DogApi {

    private $imagen;
    private $estado;

    public function __construct(array $datosApi) {
        $this->imagen = $datosApi['message'] ?? '';
        $this->estado = $datosApi['status'] ?? '';
    }

    public function obtenerDatos() {
        return [
            'imagen' => $this->imagen,
            'estado' => $this->estado
        ];
    }

    public static function procesarRazas(array $datosApi) {
        if (!isset($datosApi['message'])) {
            return [];
        }

        $resultado = [];

        foreach ($datosApi['message'] as $raza => $subrazas) {
            if (empty($subrazas)) {
                $resultado[] = $raza;
            } else {
                foreach ($subrazas as $subraza) {
                    $resultado[] = "{$raza}/{$subraza}";
                }
            }
        }

        sort($resultado);
        return $resultado;
    }
}
