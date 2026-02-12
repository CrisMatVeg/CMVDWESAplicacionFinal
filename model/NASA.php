<?php
/**
 * Clase NASA
 *
 * Representa la respuesta de la API de la NASA (Astronomy Picture of the Day)
 * y encapsula los datos de la imagen, título, descripción y tipo de media.
 *
 * @package APIs
 * @author Cristian Mateos
 * @version 1.0
 */
class NASA {

    /** @var string Título de la foto */
    private $titulo;

    /** @var string Fecha de la foto */
    private $fecha;

    /** @var string Descripción de la foto */
    private $descripcion;

    /** @var string URL de la foto */
    private $url;

    /** @var string URL de la foto en alta resolución */
    private $urlHd;

    /** @var string Tipo de media (imagen, video, etc.) */
    private $tipoMedia;

    /**
     * Constructor
     *
     * Inicializa los datos de la API a partir del array devuelto.
     *
     * @param array $datosApi Array obtenido de la API con keys: title, date, explanation, url, hdurl, media_type
     */
    public function __construct(array $datosApi) {
        $this->titulo = $datosApi['title'] ?? '';
        $this->fecha = $datosApi['date'] ?? '';
        $this->descripcion = $datosApi['explanation'] ?? '';
        $this->url = $datosApi['url'] ?? '';
        $this->urlHd = $datosApi['hdurl'] ?? '';
        $this->tipoMedia = $datosApi['media_type'] ?? '';
    }

    /**
     * Devuelve un array con los datos de la foto de la NASA
     *
     * @return array Array asociativo con keys: titulo, fecha, descripcion, url, urlHd, tipoMedia
     */
    public function obtenerDatosFotoNasa(): array {
        return [
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
            'url' => $this->url,
            'urlHd' => $this->urlHd,
            'tipoMedia' => $this->tipoMedia
        ];
    }
}
?>
