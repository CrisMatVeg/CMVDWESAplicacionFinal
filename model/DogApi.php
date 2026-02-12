<?php
/**
 * Clase DogApi
 *
 * Representa la respuesta de la API de perros (Dog API) y procesa 
 * la información de imágenes y razas.
 *
 * @package APIs
 * @author Cristian Mateos
 * @version 1.0
 */
class DogApi {

    /** @var string URL de la imagen */
    private $imagen;

    /** @var string Estado de la respuesta de la API */
    private $estado;

    /**
     * Constructor
     *
     * Inicializa los datos de la API a partir del array devuelto
     *
     * @param array $datosApi Array obtenido de la API con keys 'message' y 'status'
     */
    public function __construct(array $datosApi) {
        $this->imagen = $datosApi['message'] ?? '';
        $this->estado = $datosApi['status'] ?? '';
    }

    /**
     * Devuelve un array con los datos de la foto del perro
     *
     * @return array Array asociativo con keys 'imagen' y 'estado'
     */
    public function obtenerDatosFotoPerro(): array {
        return [
            'imagen' => $this->imagen,
            'estado' => $this->estado
        ];
    }

    /**
     * Procesa las razas de perros recibidas desde la API
     *
     * Convierte el array de subrazas en strings con formato "raza/subraza" 
     * y ordena alfabéticamente.
     *
     * @param array $datosApi Array devuelto por la API con key 'message'
     * @return array Array de strings con todas las razas procesadas
     */
    public static function procesarRazas(array $datosApi): array {
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

        sort($resultado, SORT_STRING);
        return $resultado;
    }
}
?>
