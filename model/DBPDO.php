<?php
require_once __DIR__ . '/../config/confDBPDO.php';

class DBPDO {

    /**
     * Ejecuta una consulta SQL en la base de datos y devuelve el PDOStatement.
     * No hace fetch ni interpreta resultados.
     *
     * @param string $sql La consulta SQL a ejecutar
     * @param array|null $parametros Parámetros para consultas preparadas
     * @return PDOStatement Objeto PDOStatement ya ejecutado
     * @throws PDOException Si ocurre algún error
     */
    public static function ejecutarConsulta($sql, $parametros = null) {
        try {
            $conexion = new PDO(DSN, USERNAME, PASSWORD);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $consulta = $conexion->prepare($sql);
            $consulta->execute($parametros);
            return $consulta;
        } catch (PDOException $e) {
            $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'] ?? '';
            $_SESSION['paginaEnCurso'] = 'error';
            $_SESSION['error'] = new AppError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $_SESSION['paginaAnterior']);
            header('Location: indexLoginLogoff.php');
            exit;
        }
    }
}
?>
