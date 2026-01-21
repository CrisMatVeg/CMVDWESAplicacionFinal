<?php
class DogApi {
    private $rest;
    //no utiliza api key

    public function __construct() {
        $this->rest = new REST();
    }

    /**
     * @return array|null Información de la foto o null si falla
     */
    public function obtenerPerro($raza = null) {

        if ($raza) {
            $url = "https://dog.ceo/api/breed/{$raza}/images/random";
        } else {
            $url = "https://dog.ceo/api/breeds/image/random";
        }

        return $this->rest->obtenerDatos($url);
    }

    public function obtenerRazas(){
        $url = "https://dog.ceo/api/breeds/list/all";
        $datos = $this->rest->obtenerDatos($url);

        if (!$datos || !isset($datos['message'])) {
            return [];
        }

        $resultado = [];

        foreach ($datos['message'] as $raza => $subrazas) {
            if (empty($subrazas)) {
                $resultado[] = $raza;
            } else {
                foreach ($subrazas as $subraza) {
                    $resultado[] = $raza . '/' . $subraza;
                }
            }
        }

        sort($resultado);
        return $resultado;
    }
}
?>
