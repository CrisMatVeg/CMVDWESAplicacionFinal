<?php
/**
 * Clase Usuario
 *
 * Representa un usuario del sistema con sus datos de acceso, perfil, 
 * número de conexiones y fecha/hora de última conexión.
 *
 * @package Usuarios
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
     * Constructor de la clase Usuario
     *
     * Inicializa todas las propiedades del usuario.
     *
     * @param string $codUsuario Código único del usuario
     * @param string $password Contraseña del usuario
     * @param string $descUsuario Nombre o descripción del usuario
     * @param int $numConexiones Número de conexiones realizadas
     * @param string $fechaHoraUltimaConexion Fecha/hora de la última conexión
     * @param string $perfil Perfil del usuario
     * @param string|null $imagenUsuario Imagen del usuario (opcional)
     * @param string $fechaHoraUltimaConexionAnterior Fecha/hora de la penúltima conexión
     */
    public function __construct($codDepartamento, $descDepartamento, $fechaCreacionDepartamento, $volumenDeNegocio, $fechaBajaDepartamento) {
        $this->codDepartamento = $codDepartamento;
        $this->descDepartamento = $descDepartamento;
        $this->fechaCreacionDepartamento = $fechaCreacionDepartamento;
        $this->volumenDeNegocio = $volumenDeNegocio;
        $this->fechaBajaDepartamento = $fechaBajaDepartamento;
    }

    /**
     * Obtiene el código del usuario
     * @return string Código del usuario
     */
    public function getCodDepartamento() {
        return $this->codDepartamento; 
    }

    /**
     * Obtiene la contraseña del usuario
     * @return string Contraseña del usuario
     */
    public function getDescDepartamento() { 
        return $this->descDepartamento; 
    }

    /**
     * Obtiene la descripción o nombre del usuario
     * @return string Descripción del usuario
     */
    public function getFechaCreacionDepartamento() { 
        return $this->fechaCreacionDepartamento; 
    }

    /**
     * Obtiene el perfil del usuario
     * @return string Perfil del usuario
     */
    public function getVolumenDeNegocio() { 
        return $this->volumenDeNegocio; 
    }

    /**
     * Obtiene el número de conexiones realizadas por el usuario
     * @return int Número de conexiones
     */
    public function getFechaBajaDepartamento() { 
        return $this->fechaBajaDepartamento; 
    }
}
?>
