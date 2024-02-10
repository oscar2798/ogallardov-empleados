private $mysqli;

    function __construct(){
        try {
            $this->conexionDB = ConexionDB::conexionDB();
            $this->mysqli = new mysqli(
                $this->conexionDB['host'],
                $this->conexionDB['user'],
                $this->conexionDB['password'],
                $this->conexionDB['database'],
                $this->conexionDB['port']
            );
            if ($this->mysqli->connect_errno) {
                echo "Error en la conexion de BD " . $this->mysqli->connect_error;
            }
            $this->errors = array();
        } catch (Exception $ex) {
            //mostrar mensaje de error de constructor de BaseDeDatos
            echo 'Error en el constructor de Base de Datos';
            die;
        }
    }

    public function ejecutarConsulta($consulta) {
        $sql = $this->mysqli->query($consulta)->fetch_assoc();
        return $sql;
    }

    public function consultar($tabla, $condicionales = array()) {
        $sqlWheres = $this->obtenerCondicionales($condicionales);

        $consulta = "SELECT * FROM ".$tabla." ".$sqlWheres;
        $sql = $this->ejecutarConsulta($consulta);

        echo json_encode($sql);
        /* $indexRegistro = 0;
        $array_registros = array();
        while ($registro = $sql->fetch_assoc()){
            foreach ($registro as $columna => $valor){
                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
            }
            $indexRegistro++;
        }
        return $array_registros; */
    }

    private function obtenerCondicionales($condicionales)
    {
        $condiciones = ' where 1=1';
        $index = 1;
        $max = sizeof($condicionales);
        foreach ($condicionales as $columna => $valor) {
            if ($index <= $max) {
                if (strpos($valor, '%') !== false) {
                    $condiciones .= " AND $columna LIKE '$valor'";
                } else {
                    $condiciones .= " AND $columna = '$valor'";
                }
            }
            $index++;
        }
        return $condiciones;
    }






    $conexion = array(
            'host' => 'localhost',
            'port' => '3306',
            'user' => 'root',
            'password' => '',
            'database' => 'softura'
        );