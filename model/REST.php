<?php
// app/modelos/REST.php
class REST {

    /**
     * Realiza una solicitud GET a una URL usando cURL y devuelve el resultado decodificado como array.
     *
     * @param string $url URL de la API a consultar
     * @return array|null Datos decodificados en array asociativo o null si falla
     */
    public function obtenerDatos($url) {
        // Inicializar cURL
        $ch = curl_init();

        // Configurar opciones
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   // devolver resultado como string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   // seguir redirecciones
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);            // timeout 15 segundos
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // verificar certificado SSL

        // Ejecutar la solicitud
        $respuesta = curl_exec($ch);

        // Capturar errores
        if ($respuesta === false) {
            // Opcional: log de error
            // error_log('cURL error: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }

        // Cerrar cURL
        curl_close($ch);

        // Decodificar JSON
        $datosDecodificados = json_decode($respuesta, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null; // error en JSON
        }

        return $datosDecodificados;
    }
}
?>
