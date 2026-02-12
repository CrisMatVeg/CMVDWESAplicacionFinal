<?php
/**
 * Clase Departamento
 *
 * Representa un departamento con su código, descripción, fecha de creación, 
 * volumen de negocio y fecha de baja (si existe).
 *
 * @package Modelos
 * @author Cristian Mateos
 * @version 1.0
 */
class Departamento {
    private $codDepartamento;
    private $descDepartamento;
    private $fechaCreacionDepartamento;
    private $volumenDeNegocio;
    private $fechaBajaDepartamento;

    /**
     * Constructor de la clase Departamento
     *
     * Inicializa todas las propiedades del departamento.
     *
     * @param string $codDepartamento Código único del departamento
     * @param string $descDepartamento Descripción del departamento
     * @param string $fechaCreacionDepartamento Fecha de creación del departamento
     * @param float $volumenDeNegocio Volumen de negocio del departamento
     * @param string|null $fechaBajaDepartamento Fecha de baja del departamento (opcional)
     */
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento = null) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

    /**
     * Obtiene el código del departamento
     * @return string Código del departamento
     */
    public function getCodDepartamento() {
        return $this->codDepartamento; 
    }

    /**
     * Obtiene la descripción del departamento
     * @return string Descripción del departamento
     */
    public function getDescDepartamento() { 
        return $this->descDepartamento; 
    }

    /**
     * Obtiene la fecha de creación del departamento
     * @return string Fecha de creación
     */
    public function getFechaCreacionDepartamento() { 
        return $this->fechaCreacionDepartamento; 
    }

    /**
     * Obtiene el volumen de negocio del departamento
     * @return float Volumen de negocio
     */
    public function getVolumenDeNegocio() { 
        return $this->volumenDeNegocio; 
    }

    /**
     * Obtiene la fecha de baja del departamento
     * @return string|null Fecha de baja, o null si no existe
     */
    public function getFechaBajaDepartamento() { 
        return $this->fechaBajaDepartamento; 
    }
}
?>
