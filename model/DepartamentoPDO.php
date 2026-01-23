<?php
require_once 'DBPDO.php';
require_once 'Departamento.php';

class DepartamentoPDO {

    // Validar usuario en la base de datos
    public static function buscarDepartamentos() {
        $sql = "SELECT * FROM T02_Departamento";
        $stmt = DBPDO::ejecutarConsulta($sql, null);
        $objetoResultado = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!$objetoResultado) {
            return null;
        }
        return $objetoResultado;
    }
}
?>
