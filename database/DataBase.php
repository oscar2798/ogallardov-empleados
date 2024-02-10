<?php 

include_once("ConexionDB.php");

class DataBase {

    private $conexionDB;

    function __construct(){
        $this->conexionDB = ConexionDB::conexionDB();
    }

    public function ejecutarConsulta($consulta) {
        $sql = $this->conexionDB->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    public function obtenerLista($tabla) {

        $consulta = "SELECT * FROM ".$tabla;

        $sql = $this->ejecutarConsulta($consulta);

        $resultSql = $sql->get_result()->fetch_all(MYSQLI_ASSOC);

        return $resultSql;
    }

    public function eliminar($tabla, $empleado) {

        $id = $empleado['id_empleado'];
        $clave = $empleado['clave_empleado'];
        $name = $empleado['nombre'];
        $edad = $empleado['edad'];
        $fecha = $empleado['fecha_nacimiento'];
        $genero = $empleado['genero'];
        $sueldo = $empleado['sueldo_base'];

        $consulta = "UPDATE $tabla"." SET id_empleado='".$id."', clave_empleado='".$clave."', nombre='".$name."', edad=".$edad.
        ", fecha_nacimiento='".$fecha."', genero='".$genero."', sueldo_base=".$sueldo.", activo=false WHERE id_empleado=".$id;
        echo $consulta;
        $sql = $this->ejecutarConsulta($consulta);

        echo json_encode($sql);

        
    }
    
}