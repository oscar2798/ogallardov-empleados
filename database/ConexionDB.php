<?php 

class ConexionDB {

    public static function conexionDB() {
        try {
            $conexion = mysqli_connect('localhost','root','','softura','3306');
            $conexion ->set_charset('utf8');
    
            if ($conexion->connect_errno) {
                echo "Error en la conexion de BD " . $conexion->connect_error;
            }
    
        } catch (Exception $e) {
            echo 'Error en el constructor de Base de Datos';
            die;
        }

        return $conexion;
    }
}