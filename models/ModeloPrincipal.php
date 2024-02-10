<?php 

include_once ("../database/DataBase.php");

class ModeloPrincipal extends DataBase {
    private $tabla;

    public function __construct($nombre_tabla) {
        parent::__construct();
        $this->tabla = $nombre_tabla;
    }

    public function obtenerRegistros() {
        $registros = $this->obtenerLista($this->tabla);
        return $registros;
    }

    public function agregarRegistro($paramsForm) {
        return $this->agregar($this->tabla, $paramsForm);
    }

    public function actualizarRegistro($paramsForm) {
        return $this->actualizar($this->tabla, $paramsForm);
    }

    public function eliminarRegistro($empleado) {
        return $this->eliminar($this->tabla, $empleado);
    }
}