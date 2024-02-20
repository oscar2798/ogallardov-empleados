<?php 

include_once("../models/ModeloPrincipal.php");

class DetalleEmpleadoModel extends ModeloPrincipal {
    private $idEmpleado;
    public function __construct($idEmpleado = null) {
        /**
         * Se le manda al modelo principal por medio
         * del constructor el nombre de la tabla para
         * hacer consultas SQL
         */
        parent::__construct("empleados_detalle");

        $this->idEmpleado = $idEmpleado;
    }

    public function obtenerDetalleEmpleadoById()
    {
        $consulta = "select * from empleados_detalle where empleado_id = ".$this->idEmpleado;
        $registros = $this->obtenerRegistroSelect($consulta);
        return $registros;
    }

    public function actalizarDetalleEmpleadoById($paramsForm)
    {
        $valores = $this->getValoresUpdate($paramsForm);
        $consulta = "UPDATE empleados_detalle $valores WHERE empleado_id = ".$this->idEmpleado;
        $registros = $this->ejecutarConsulta($consulta);
        return $registros;
    }
}