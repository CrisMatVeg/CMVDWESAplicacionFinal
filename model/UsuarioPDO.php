<?php
require_once 'DBPDO.php';
require_once 'Usuario.php';
/**
 * Clase UsuarioPDO
 *
 * Gestiona las operaciones sobre la tabla T01_Usuarios de la base de datos.
 * Permite validar usuarios, crear, editar, borrar y manejar tokens API.
 *
 * @package Modelos
 * @author Cristian Mateos
 * @version 1.0
 */
class UsuarioPDO {

    /**
     * Valida un usuario en la base de datos.
     * 
     * @param string $codUsuario Código del usuario
     * @param string|null $password Contraseña (opcional)
     * @return Usuario|null Objeto Usuario si existe y contraseña coincide, null si no
     */
    public static function validarUsuario($codUsuario, $password=null) {
        if($password!=null){
            $sql = "SELECT * FROM T01_Usuarios WHERE T01_CodUsuario = :usuario AND T01_Password = SHA2(:password,256)";
            $consulta = DBPDO::ejecutarConsulta($sql, [':usuario' => $codUsuario, ':password' => $password]);
        }else{
            $sql = "SELECT * FROM T01_Usuarios WHERE T01_CodUsuario = :usuario";
            $consulta = DBPDO::ejecutarConsulta($sql, [':usuario' => $codUsuario]);
        }
        
        $objetoResultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$objetoResultado) {
            return null;
        }

        return new Usuario(
            $objetoResultado['T01_CodUsuario'],
            $objetoResultado['T01_Password'],
            $objetoResultado['T01_DescUsuario'],
            $objetoResultado['T01_NumConexiones'],
            $objetoResultado['T01_FechaHoraUltimaConexion'],
            $objetoResultado['T01_Perfil'],
            $objetoResultado['T01_ImagenUsuario'],
            new DateTime($objetoResultado['T01_FechaHoraUltimaConexion'])
        );
    }

    /**
     * Actualiza la última conexión y número de conexiones del usuario.
     * 
     * @param Usuario $usuario Objeto usuario a actualizar
     * @return void
     */
    public static function actualizarUltimaConexionYUsuario($usuario) {
        $codUsuario = $usuario->getCodUsuario();

        $sqlUpdate = "UPDATE T01_Usuarios 
                      SET T01_NumConexiones = T01_NumConexiones + 1, 
                          T01_FechaHoraUltimaConexion = NOW() 
                      WHERE T01_CodUsuario = :usuario";
        DBPDO::ejecutarConsulta($sqlUpdate, [':usuario' => $codUsuario]);

        $sqlSelect = "SELECT T01_FechaHoraUltimaConexion FROM T01_Usuarios WHERE T01_CodUsuario = :usuario";
        $consulta = DBPDO::ejecutarConsulta($sqlSelect, [':usuario' => $codUsuario]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        $usuario->setFechaHoraUltimaConexion(new DateTime($resultado['T01_FechaHoraUltimaConexion']));
    }

    /**
     * Comprueba si un código de usuario no existe.
     * 
     * @param string $codUsuario Código del usuario
     * @return bool True si existe, False si no
     */
    public static function validarCodNoExiste($codUsuario) {
        $sql = "SELECT 1 FROM T01_Usuarios WHERE T01_CodUsuario = :codUsuario";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
        return $consulta->fetch() !== false; // true si existe, false si no
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     * 
     * @param string $codUsuario Código del usuario
     * @param string $password Contraseña
     * @param string $descUsuario Descripción o nombre
     * @return Usuario|null Objeto Usuario creado o null si falla
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario) {
        $sql = "INSERT INTO T01_Usuarios (T01_CodUsuario, T01_Password, T01_DescUsuario)
                VALUES (:codUsuario, SHA2(:password,256), :descUsuario)";

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codUsuario' => $codUsuario,
            ':password' => $password,
            ':descUsuario' => $descUsuario
        ]);

        // Si no se insertó ninguna fila, devolver null
        if ($consulta->rowCount() === 0) {
            return null;
        }

        // Validar usuario recién creado
        return self::validarUsuario($codUsuario, $password);
    }

    /**
     * Cambia la contraseña de un usuario.
     * 
     * @param Usuario $oUsuario Objeto usuario a actualizar
     * @param string $nuevaPassword Nueva contraseña
     * @return Usuario|null Usuario actualizado o null si falla
     */
    public static function cambiarPassword($oUsuario, $nuevaPassword) {
        $sql = "UPDATE T01_Usuarios 
                SET T01_Password = SHA2(:password,256) 
                WHERE T01_CodUsuario = :codUsuario";

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codUsuario' => $oUsuario->getCodUsuario(),
            ':password' => $oUsuario->getCodUsuario() . $nuevaPassword
        ]);

        if ($consulta) {
            $oUsuario->setPassword(hash('sha256', $oUsuario->getCodUsuario() . $nuevaPassword));
            return $oUsuario;
        }
        return null;
    }

    /**
     * Edita datos de un usuario existente.
     * 
     * @param string $codUsuario Código del usuario
     * @param array $datosNuevos Array asociativo de campos y valores
     * @return bool True si se actualizó, False si no
     */
    public static function editarUsuario($codUsuario, array $datosNuevos) {
        if (empty($datosNuevos)) {
            return false;
        }
    
        $campos = [];
        $parametros = [':usuario' => $codUsuario];
    
        foreach ($datosNuevos as $campo => $valor) {
            $campos[] = "$campo = :$campo";
            $parametros[":$campo"] = $valor;
        }
    
        $sql = "UPDATE T01_Usuarios 
                SET " . implode(', ', $campos) . "
                WHERE T01_CodUsuario = :usuario";
    
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
    
        return $consulta->rowCount() === 1;
    }

    /**
     * Guarda un token API para un usuario.
     * 
     * @param string $codUsuario Código del usuario
     * @param string|null $token Token a guardar
     * @return void
     */
    public static function guardarToken($codUsuario, $token) {
        $sql = "UPDATE T01_Usuarios
                SET T01_TokenApi = :token
                WHERE T01_CodUsuario = :codUsuario";
    
        DBPDO::ejecutarConsulta($sql, [
            ':token' => $token,
            ':codUsuario' => $codUsuario
        ]);
    }

    /**
     * Obtiene el token API de un usuario.
     * 
     * @param string $codUsuario Código del usuario
     * @return string|null Token o null si no existe
     */
    public static function obtenerToken($codUsuario) {
        $sql = "SELECT T01_TokenApi FROM T01_Usuarios WHERE T01_CodUsuario = :usuario";
        $consulta = DBPDO::ejecutarConsulta($sql, [':usuario' => $codUsuario]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        return $resultado['T01_TokenApi'] ?? null;
    }

    /**
     * Valida un token API.
     * 
     * @param string $token Token a validar
     * @return bool True si existe, False si no
     */
    public static function validarToken($token) {
        $sql = "SELECT 1 FROM T01_Usuarios WHERE T01_TokenApi = :token";
        $consulta = DBPDO::ejecutarConsulta($sql, [':token' => $token]);
        return $consulta->fetch() !== false;
    }
    
    /**
     * Busca usuarios filtrando por descripción.
     * 
     * @param string|null $descripcion Texto a buscar en T01_DescUsuario
     * @return Usuario[] Array de objetos Usuario
     */
    public static function buscarUsuarios($descripcion=null) {
        if ($descripcion === null || $descripcion === '') {
            $sql = "SELECT * FROM T01_Usuarios";
            $consulta = DBPDO::ejecutarConsulta($sql, null);
        }else{
            $sql = "SELECT * FROM T01_Usuarios WHERE T01_DescUsuario LIKE :descripcion";
            $consulta = DBPDO::ejecutarConsulta($sql, [':descripcion' => '%' . $descripcion . '%']);
        }
        $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $usuariosListado = [];

        foreach ($usuarios as $usuario) {
            $usuariosListado[] = new Usuario(
                $usuario['T01_CodUsuario'],
                $usuario['T01_Password'],
                $usuario['T01_DescUsuario'],
                $usuario['T01_NumConexiones'],
                $usuario['T01_FechaHoraUltimaConexion'],
                $usuario['T01_Perfil'],
                $usuario['T01_ImagenUsuario'],
                null
            );
        }

        return $usuariosListado;
    }

    /**
     * Borra un usuario de la base de datos.
     * 
     * @param string $codUsuario Código del usuario
     * @return bool True si se eliminó, False si no
     */
    public static function borrarUsuario($codUsuario) {
        $sql = "DELETE FROM T01_Usuarios WHERE T01_CodUsuario LIKE :codUsuario";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
        if ($consulta->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }
}
?>
