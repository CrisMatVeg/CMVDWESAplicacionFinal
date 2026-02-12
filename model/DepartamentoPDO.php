<?php
require_once 'DBPDO.php';
require_once 'Departamento.php';

class DepartamentoPDO {
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

    public static function seleccionarDepartamento($codDepartamento) {
        $sql = "SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento ";
        $stmt = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new Departamento(
                $fila['T02_CodDepartamento'],
                $fila['T02_DescDepartamento'],
                $fila['T02_FechaCreacionDepartamento'],
                $fila['T02_VolumenDeNegocio'],
                $fila['T02_FechaBajaDepartamento'],
            );
        } else {
            return null; // Devuelve null si no existe ese departamento
        }
    }

    public static function validarCodNoExiste($codDepartamento) {
        $sql = "SELECT 1 FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        return $consulta->fetch() !== false; // true si existe, false si no
    }

    public static function altaDepartamento($codDepartamento, $DescDepartamento, $VolumenDeNegocio) {
        $sql = "INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio)
                VALUES (:codDepartamento, :descDepartamento, NOW(), :volumendenegocio)";

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':codDepartamento' => $codDepartamento,
            ':descDepartamento' => $DescDepartamento,
            ':volumendenegocio' => $VolumenDeNegocio
        ]);

        // Si no se insertó ninguna fila, devolver null
        if ($consulta->rowCount() === 0) {
            return null;
        }

        // Validar usuario recién creado
        return true;
    }

    public static function editarDepartamento($codDepartamento, $datosNuevos) {
        if (empty($datosNuevos)) {
            return false;
        }
    
        $campos = [];
        $parametros = [':departamento' => $codDepartamento];
    
        foreach ($datosNuevos as $campo => $valor) {
            $campos[] = "$campo = :$campo";
            $parametros[":$campo"] = $valor;
        }
    
        $sql = "UPDATE T02_Departamento 
                SET " . implode(', ', $campos) . "
                WHERE T02_CodDepartamento = :departamento";
    
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
    
        return $consulta->rowCount() > 0;
    }

    public static function rehabilitarDepartamento($codDepartamento) {
        $sql = "UPDATE T02_Departamento 
                SET T02_FechaBajaDepartamento = null
                WHERE T02_CodDepartamento = :departamento";

        $parametros = [':departamento' => $codDepartamento];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
    
        return $consulta->rowCount() > 0;
    }

    public static function bajaDepartamento($codDepartamento) {
        $sql = "UPDATE T02_Departamento 
                SET T02_FechaBajaDepartamento = NOW()
                WHERE T02_CodDepartamento = :departamento";
                
        $parametros = [':departamento' => $codDepartamento];
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
    
        return $consulta->rowCount() > 0;
    }

    public static function borrarDepartamento($codDepartamento) {
        $sql = "DELETE FROM T02_Departamento WHERE T02_CodDepartamento LIKE :codDepartamento";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        if ($consulta->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }
}
?>
