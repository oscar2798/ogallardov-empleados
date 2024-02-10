<?php 

include_once("../models/ModeloPrincipal.php");

class EmpleadoModel extends ModeloPrincipal {
    public function __construct() {
        /**
         * Se le manda al modelo principal por medio
         * del constructor el nombre de la tabla para
         * hacer consultas SQL
         */
        parent::__construct("empleados");
    }
}
