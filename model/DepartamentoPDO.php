<?php
require_once 'DBPDO.php';
require_once 'Departamento.php';

/**
 * Clase DepartamentoPDO
 *
 * Gestiona las operaciones CRUD sobre la tabla T02_Departamento
 * usando PDO y la clase DBPDO.
 *
 * @package Modelos
 * @author Cristian Mateos
 * @version 1.0
 */
class DepartamentoPDO {

    /**
     * Busca departamentos filtrando por estado y/o descripción.
     *
     * @param string $estado "Todos", "Alta" o "Baja"
     * @param string|null $descripcion Texto a buscar en la descripción
     * @return array Array de objetos stdClass con los datos de los departamentos
     */
    public static function buscarDepartamentos($estado = "Todos", $descripcion = null) {

        $sql = "SELECT * FROM T02_Departamento WHERE 1=1";
        $parametros = [];
    
        if ($estado === "Alta") {
            $sql .= " AND T02_FechaBajaDepartamento IS NULL";
        } elseif ($estado === "Baja") {
            $sql .= " AND T02_FechaBajaDepartamento IS NOT NULL";
        }
    
        if (!empty($descripcion)) {
            $sql .= " AND T02_DescDepartamento LIKE :descripcion";
            $parametros[':descripcion'] = '%' . $descripcion . '%';
        }
    
        $stmt = DBPDO::ejecutarConsulta($sql, $parametros);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Obtiene un departamento por su código
     *
     * @param string $codDepartamento
     * @return Departamento|null Devuelve un objeto Departamento o null si no existe
     */
    public static function seleccionarDepartamento($codDepartamento) {
        $sql = "SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $stmt = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new Departamento(
                $fila['T02_CodDepartamento'],
                $fila['T02_DescDepartamento'],
                $fila['T02_FechaCreacionDepartamento'],
                $fila['T02_VolumenDeNegocio'],
                $fila['T02_FechaBajaDepartamento'] // <--- eliminado la coma final
            );
        } else {
            return null;
        }
    }

    /**
     * Comprueba si un código de departamento ya existe
     *
     * @param string $codDepartamento
     * @return bool True si existe, False si no
     */
    public static function validarCodNoExiste($codDepartamento) {
        $sql = "SELECT 1 FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        return $consulta->fetch() !== false;
    }

    /**
     * Da de alta un nuevo departamento
     *
     * @param string $codDepartamento
     * @param string $DescDepartamento
     * @param float $VolumenDeNegocio
     * @return bool|null True si se insertó, null si falló
     */
    public static function altaDepartamento($codDepartamento, $DescDepartamento, $VolumenDeNegocio) {
        $sql = "INSERT INTO T02_Departamento 
                (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio)
                VALUES (:codDepartamento, :descDepartamento, NOW(), :volumendenegocio)";

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codDepartamento' => $codDepartamento,
            ':descDepartamento' => $DescDepartamento,
            ':volumendenegocio' => $VolumenDeNegocio
        ]);

        return $consulta->rowCount() > 0 ? true : null;
    }

    /**
     * Edita un departamento
     *
     * @param string $codDepartamento
     * @param array $datosNuevos Array asociativo con los campos a modificar
     * @return bool True si se modificó al menos un campo
     */
    public static function editarDepartamento($codDepartamento, $datosNuevos) {
        if (empty($datosNuevos)) return false;
    
        $campos = [];
        $parametros = [':departamento' => $codDepartamento];
    
        foreach ($datosNuevos as $campo => $valor) {
            $campos[] = "$campo = :$campo";
            $parametros[":$campo"] = $valor;
        }
    
        $sql = "UPDATE T02_Departamento SET " . implode(', ', $campos) . " WHERE T02_CodDepartamento = :departamento";
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
    
        return $consulta->rowCount() > 0;
    }

    /**
     * Rehabilita un departamento (pone FechaBajaDepartamento a NULL)
     *
     * @param string $codDepartamento
     * @return bool True si se modificó
     */
    public static function rehabilitarDepartamento($codDepartamento) {
        $sql = "UPDATE T02_Departamento SET T02_FechaBajaDepartamento = NULL WHERE T02_CodDepartamento = :departamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':departamento' => $codDepartamento]);
        return $consulta->rowCount() > 0;
    }

    /**
     * Da de baja un departamento (pone FechaBajaDepartamento a NOW())
     *
     * @param string $codDepartamento
     * @return bool True si se modificó
     */
    public static function bajaDepartamento($codDepartamento) {
        $sql = "UPDATE T02_Departamento SET T02_FechaBajaDepartamento = NOW() WHERE T02_CodDepartamento = :departamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':departamento' => $codDepartamento]);
        return $consulta->rowCount() > 0;
    }

    /**
     * Borra un departamento de la base de datos
     *
     * @param string $codDepartamento
     * @return bool True si se eliminó, False si no existía
     */
    public static function borrarDepartamento($codDepartamento) {
        $sql = "DELETE FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        return $consulta->rowCount() > 0;
    }
}
?>
