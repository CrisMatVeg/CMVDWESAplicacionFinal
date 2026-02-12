<?php
class REST {

    private const URL_NASA = 'https://api.nasa.gov/planetary/apod';
    private const URL_DOG_RANDOM = 'https://dog.ceo/api/breeds/image/random';
    private const URL_DOG_BREED = 'https://dog.ceo/api/breed';
    private const URL_DOG_BREEDS = 'https://dog.ceo/api/breeds/list/all';

    public function obtenerDatos($url) {
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

    /* ========= LLAMADAS CENTRALIZADAS ========= */

    public function obtenerNasa($apiKey, $fecha = null) {
        $url = self::URL_NASA . "?api_key={$apiKey}";
        if ($fecha) {
            $url .= "&date={$fecha}";
        }
        return $this->obtenerDatos($url);
    }

    public function obtenerPerro($raza = null) {
        if ($raza) {
            $url = self::URL_DOG_BREED . "/{$raza}/images/random";
        } else {
            $url = self::URL_DOG_RANDOM;
        }
        return $this->obtenerDatos($url);
    }

    public function obtenerRazasPerro() {
        return $this->obtenerDatos(self::URL_DOG_BREEDS);
    }
}
