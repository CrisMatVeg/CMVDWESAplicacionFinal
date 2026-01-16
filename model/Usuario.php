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
class Usuario {
    /**
     * Código único del usuario
     * @var string
     */
    private $codUsuario;

    /**
     * Contraseña del usuario
     * @var string
     */
    private $password;

    /**
     * Descripción o nombre del usuario
     * @var string
     */
    private $descUsuario;

    /**
     * Número de conexiones realizadas por el usuario
     * @var int
     */
    private $numConexiones;

    /**
     * Fecha y hora de la última conexión
     * @var string
     */
    private $fechaHoraUltimaConexion;

    /**
     * Fecha y hora de la penúltima conexión
     * @var string
     */
    private $fechaHoraUltimaConexionAnterior;

    /**
     * Perfil del usuario (por ejemplo: admin, usuario, invitado)
     * @var string
     */
    private $perfil;

    /**
     * Ruta o nombre de la imagen del usuario
     * @var string
     */
    private $imagenUsuario;

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
    public function __construct($codUsuario, $password, $descUsuario, $numConexiones, $fechaHoraUltimaConexion, $perfil, $imagenUsuario, $fechaHoraUltimaConexionAnterior) {
        $this->codUsuario = $codUsuario;
        $this->password = $password;
        $this->descUsuario = $descUsuario;
        $this->numConexiones = $numConexiones;
        $this->fechaHoraUltimaConexion = $fechaHoraUltimaConexion;
        $this->perfil = $perfil;
        $this->imagenUsuario = $imagenUsuario == null ? '' : $imagenUsuario;
        $this->fechaHoraUltimaConexionAnterior = $fechaHoraUltimaConexionAnterior;
    }

    /**
     * Obtiene el código del usuario
     * @return string Código del usuario
     */
    public function getCodUsuario() {
        return $this->codUsuario; 
    }

    /**
     * Obtiene la contraseña del usuario
     * @return string Contraseña del usuario
     */
    public function getPassword() { 
        return $this->password; 
    }

    /**
     * Obtiene la descripción o nombre del usuario
     * @return string Descripción del usuario
     */
    public function getDescUsuario() { 
        return $this->descUsuario; 
    }

    /**
     * Obtiene el perfil del usuario
     * @return string Perfil del usuario
     */
    public function getPerfil() { 
        return $this->perfil; 
    }

    /**
     * Obtiene el número de conexiones realizadas por el usuario
     * @return int Número de conexiones
     */
    public function getNumConexiones() { 
        return $this->numConexiones; 
    }

    /**
     * Obtiene la fecha y hora de la última conexión
     * @return string Fecha y hora de la última conexión
     */
    public function getFechaHoraUltimaConexion() { 
        return $this->fechaHoraUltimaConexion; 
    }

    /**
     * Establece la fecha y hora de la última conexión
     * @param string $fecha Nueva fecha/hora de la última conexión
     */
    public function setFechaHoraUltimaConexion($fecha) {
        $this->fechaHoraUltimaConexion = $fecha;
    }

    /**
     * Obtiene la fecha y hora de la penúltima conexión
     * @return string Fecha y hora de la penúltima conexión
     */
    public function getFechaHoraUltimaConexionAnterior() { 
        return $this->fechaHoraUltimaConexionAnterior; 
    }
}
?>
