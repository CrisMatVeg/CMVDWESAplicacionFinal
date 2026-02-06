<?php
require_once 'DBPDO.php';
require_once 'Usuario.php';

class UsuarioPDO {

    // Validar usuario en la base de datos
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
            null,
            $objetoResultado['T01_Perfil'],
            $objetoResultado['T01_ImagenUsuario'],
            new DateTime($objetoResultado['T01_FechaHoraUltimaConexion'])
        );
    }

    // Actualiza última conexión
    public function actualizarUltimaConexionYUsuario($usuario) {
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

    // Comprueba si el código ya existe
    public static function validarCodNoExiste($codUsuario) {
        $sql = "SELECT 1 FROM T01_Usuarios WHERE T01_CodUsuario = :codUsuario";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
        return $consulta->fetch() !== false; // true si existe, false si no
    }

    // Alta de usuario
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

    public static function cambiarPassword($codUsuario, $passwordNueva) {
        $passwordConcatenada = $codUsuario . $passwordNueva;
        $sql = "UPDATE T01_Usuarios 
                SET T01_Password = SHA2(:password,256) 
                WHERE T01_CodUsuario = :usuario";
    
        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':password' => $passwordConcatenada,
            ':usuario'  => $codUsuario
        ]);
        return $consulta->rowCount() === 1;
    }

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
