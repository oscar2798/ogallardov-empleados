<?php

include_once ("../controllers/EmpleadosController.php");

$peticion = $_GET['peticion'];
$funcion = $_GET['funcion'];
$data = $_POST;

$empleadoController = new EmpleadosController();

if(isset($_GET['peticion']) && $_GET['peticion'] != '' && isset($_GET['funcion']) && $_GET['funcion'] != ''){
    switch ($peticion){
        case 'empleados':
            switch ($funcion){
                case 'listado':
                    $resultado = $empleadoController->obtenerEmpleados();
                    echo json_encode($resultado);
                    break;
                case 'agregar-actualizar':
                    $resultado = $empleadoController->guardarEmpleado($data);
                    echo json_encode($resultado);
                    break;
                case 'eliminar':
                    $resultado = $empleadoController->eliminarEmpleado($data);
                    echo json_encode($resultado);
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(array(
                        'success' => false,
                        'msg' => array(
                            'Error, No se encontró la petición solicitada'
                        )
                    ));
                    break;
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(array(
                'success' => false,
                'msg' => array(
                    'Error, No se encontró la petición solicitada'
                )
            ));
            break;
    }
}else{
    http_response_code(404);
    echo json_encode(array(
        'success' => false,
        'msg' => array(
            'Error, No se encontró la petición solicitada'
        )
    ));
}