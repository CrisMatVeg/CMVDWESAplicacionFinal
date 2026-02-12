<?php
/**
 * Clase REST
 *
 * Proporciona métodos para consumir APIs externas (NASA y Dog API)
 * y devolver los datos en formato array asociativo.
 *
 * @package APIs
 * @author Cristian Mateos
 * @version 1.0
 */
class REST {

    /** @var string URL base de la API de NASA */
    private const URL_NASA = 'https://api.nasa.gov/planetary/apod';

    /** @var string URL para obtener imagen aleatoria de perro */
    private const URL_DOG_RANDOM = 'https://dog.ceo/api/breeds/image/random';

    /** @var string URL base para obtener imagen de raza específica */
    private const URL_DOG_BREED = 'https://dog.ceo/api/breed';

    /** @var string URL para obtener listado de todas las razas */
    private const URL_DOG_BREEDS = 'https://dog.ceo/api/breeds/list/all';

    /**
     * Realiza una petición HTTP GET a la URL indicada y devuelve los datos decodificados.
     *
     * @param string $url URL de la API
     * @return array|null Array asociativo con los datos, o null si hay error
     */
    private function obtenerDatos(string $url): ?array {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $respuesta = curl_exec($ch);

        if ($respuesta === false) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $datos = json_decode($respuesta, true);
        return json_last_error() === JSON_ERROR_NONE ? $datos : null;
    }

    /* ========= MÉTODOS PÚBLICOS PARA LLAMADAS A LA API ========= */

    /**
     * Obtiene los datos de la foto del día de NASA
     *
     * @param string $apiKey Clave API de NASA
     * @param string|null $fecha Fecha específica (YYYY-MM-DD), opcional
     * @return array|null Array con los datos de la API o null si falla
     */
    public function obtenerNasa(string $apiKey, ?string $fecha = null): ?array {
        $url = self::URL_NASA . "?api_key={$apiKey}";
        if ($fecha) {
            $url .= "&date={$fecha}";
        }
        return $this->obtenerDatos($url);
    }

    /**
     * Obtiene la imagen de un perro
     *
     * @param string|null $raza Nombre de la raza (ej. 'hound/afghan'), opcional
     * @return array|null Array con los datos de la API o null si falla
     */
    public function obtenerPerro(?string $raza = null): ?array {
        $url = $raza ? self::URL_DOG_BREED . "/{$raza}/images/random" : self::URL_DOG_RANDOM;
        return $this->obtenerDatos($url);
    }

    /**
     * Obtiene el listado completo de razas de perros
     *
     * @return array|null Array asociativo con todas las razas o null si falla
     */
    public function obtenerRazasPerro(): ?array {
        return $this->obtenerDatos(self::URL_DOG_BREEDS);
    }
}
?>
