<?php
require_once 'DBPDO.php';
require_once 'Departamento.php';

class DepartamentoPDO {
    public static function buscarDepartamentos($descripcion=null) {
        if($descripcion==null){
            $sql = "SELECT * FROM T02_Departamento";
            $stmt = DBPDO::ejecutarConsulta($sql, null);
        }else{
            $sql = "SELECT * FROM T02_Departamento WHERE T02_DescDepartamento LIKE :descripcion";
            $stmt = DBPDO::ejecutarConsulta($sql, [':descripcion' => '%' . $descripcion . '%']);
        }
        $objetoResultado = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $objetoResultado;
    }

    public static function seleccionarDepartamento($codDepartamento) {
        $sql = "SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento ";
        $stmt = DBPDO::ejecutarConsulta($sql, [':codDepartamento' => $codDepartamento]);
        $objetoResultado = $stmt->fetch(PDO::FETCH_OBJ);
        return $objetoResultado;
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
