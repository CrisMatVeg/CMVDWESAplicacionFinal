<?php
// app/modelos/REST.php
class REST {

    /**
     * Realiza una solicitud GET a una URL y devuelve el resultado decodificado como array.
     *
     * @param string $url URL de la API a consultar
     * @return array|null Datos decodificados en array asociativo o null si falla
     */
    public function obtenerDatos($url) {
        $respuesta = @file_get_contents($url);

        if ($respuesta === false) {
            return null; // manejar error
        }

        $datosDecodificados = json_decode($respuesta, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null; // error en JSON
        }

        return $datosDecodificados;
    }
}
?>
