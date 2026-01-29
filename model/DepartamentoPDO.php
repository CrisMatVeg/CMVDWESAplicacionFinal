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
}
?>
