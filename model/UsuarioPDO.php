<?php
require_once 'DBPDO.php';
require_once 'Usuario.php';

class UsuarioPDO {

    // Validar usuario en la base de datos
    public static function validarUsuario($codUsuario, $password) {
        $sql = "SELECT * FROM T01_Usuarios WHERE T01_CodUsuario = :usuario AND T01_Password = SHA2(:password,256)";
        $stmt = DBPDO::ejecutarConsulta($sql, [':usuario' => $codUsuario, ':password' => $password]);
        $objetoResultado = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $stmt = DBPDO::ejecutarConsulta($sqlSelect, [':usuario' => $codUsuario]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $usuario->setFechaHoraUltimaConexion(new DateTime($resultado['T01_FechaHoraUltimaConexion']));
    }

    // Comprueba si el código ya existe
    public static function validarCodNoExiste($codUsuario) {
        $sql = "SELECT 1 FROM T01_Usuarios WHERE T01_CodUsuario = :codUsuario";
        $stmt = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
        return $stmt->fetch() !== false; // true si existe, false si no
    }

    // Alta de usuario
    public static function altaUsuario($codUsuario, $password, $descUsuario) {
        $sql = "INSERT INTO T01_Usuarios (T01_CodUsuario, T01_Password, T01_DescUsuario)
                VALUES (:codUsuario, SHA2(:password,256), :descUsuario)";

        $stmt = DBPDO::ejecutarConsulta($sql, [
            ':codUsuario' => $codUsuario,
            ':password' => $password,
            ':descUsuario' => $descUsuario
        ]);

        // Si no se insertó ninguna fila, devolver null
        if ($stmt->rowCount() === 0) {
            return null;
        }

        // Validar usuario recién creado
        return self::validarUsuario($codUsuario, $password);
    }
}
?>
