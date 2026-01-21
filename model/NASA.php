<?php
class NASA {
    private $rest;
    private $apiKey;

    public function __construct($claveApi) {
        $this->rest = new REST();
        $this->apiKey = $claveApi;
    }

    /**
     * Obtiene la foto del día desde la API de la NASA.
     *
     * @return array|null Información de la foto o null si falla
     */
    public function obtenerFotoDelDia($fecha=null) {
        $url = "https://api.nasa.gov/planetary/apod?api_key={$this->apiKey}";
        if ($fecha) {
            $url .= "&date=" . $fecha;
        }
        return $this->rest->obtenerDatos($url);
    }
}
?>
