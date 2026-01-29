<?php
class NASA {
    private $titulo;
    private $fecha;
    private $descripcion;
    private $url;
    private $urlHd;
    private $tipoMedia;

    public function __construct(array $datosApi) {
        $this->titulo = $datosApi['title'] ?? '';
        $this->fecha = $datosApi['date'] ?? '';
        $this->descripcion = $datosApi['explanation'] ?? '';
        $this->url = $datosApi['url'] ?? '';
        $this->urlHd = $datosApi['hdurl'] ?? '';
        $this->tipoMedia = $datosApi['media_type'] ?? '';
    }

    public function obtenerDatos() {
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
