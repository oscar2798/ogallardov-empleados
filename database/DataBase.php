<?php 

include_once("ConexionDB.php");

class DataBase {

    private $conexionDB;

    function __construct(){
        $this->conexionDB = ConexionDB::conexionDB();
    }

    public function ejecutarConsulta($consulta) {
        $sql = $this->conexionDB->query($consulta);
        return $sql;
    }

    public function obtenerLista($tabla) {

        $consulta = "SELECT * FROM ".$tabla." WHERE activo=1";

        $sql = $this->ejecutarConsulta($consulta);

        $resultSql = $sql->fetch_all(MYSQLI_ASSOC);

        return $resultSql;
    }
    public function agregar($tabla, $paramsForm) {

        $valoresColumnas = $this->getValoresInsert($paramsForm);

        $consulta = "INSERT INTO ". $tabla . " (" . $valoresColumnas['columnas'] . ") VALUES (" . $valoresColumnas['valores'] . ")";

        $sql = $this->ejecutarConsulta($consulta);

        return $sql;
    }
    public function actualizar($tabla, $paramsForm) {

        $sqlSets = $this->getValoresUpdate($paramsForm);

        $consulta = "UPDATE $tabla $sqlSets"." WHERE id_empleado=".$paramsForm['id_empleado'];

        $sql = $this->ejecutarConsulta($consulta);

        return $sql;
    }

    public function eliminar($tabla, $idEmpleado) {

        $id = $idEmpleado['idEmpleado'];

        $consulta = "UPDATE $tabla"." SET activo=false WHERE id_empleado=".$id;
        
        $sql = $this->ejecutarConsulta($consulta);

        return $sql;
    }

    public function obtenerRegistroSelect($consulta) {
        $sql = $this->ejecutarConsulta($consulta);
        $resultadoSql = $sql->fetch_assoc();
        return $resultadoSql;
    }

    public function ultimoIdInsertado(){
        return $this->conexionDB->insert_id;
    }

    public function getValoresUpdate($paramsFormUpdate) {
        $set = " SET";
        $index = 1;
        $max = sizeof($paramsFormUpdate);
        foreach ($paramsFormUpdate as $columna => $valor) {
            if ($index < $max) {
                $set .= " $columna = '$valor',";
            } else {
                $set .= " $columna = '$valor'";
            }
            $index++;
        }
        return $set;
    }

    private function getValoresInsert($valoresInsert)
    {
        $respuesta = array();
        $nombres_columnas = "";
        $valores_columnas = "";
        $iteracion_campos = 1;
        $max_it_campos = sizeof($valoresInsert);
        foreach ($valoresInsert as $columna => $valor) {
            $nombres_columnas .= $columna;
            $valores_columnas .= "'" . $valor . "'";
            if ($iteracion_campos < $max_it_campos) {
                $nombres_columnas .= ",";
                $valores_columnas .= ",";
            }
            $iteracion_campos++;
        }
        $respuesta['columnas'] = $nombres_columnas;
        $respuesta['valores'] = $valores_columnas;
        return $respuesta;
    }
    
}