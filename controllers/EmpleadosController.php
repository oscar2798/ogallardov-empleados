<?php 

include_once("../models/EmpleadoModel.php");

class EmpleadosController {

    public function obtenerEmpleados() {
        $empleadoModel = new EmpleadoModel();
        $listaEmpleados = $empleadoModel->obtenerRegistros();

        $respuesta = array(
            'success' => true,
            'data' => array(
                'empleados' => $listaEmpleados
            )
        );
        return $respuesta;
    }

    public function guardarEmpleado($paramsForm) {

       /*  if(isset($paramsForm['id']) && !empty($paramsForm['id'])){
            $empleadoModel = new EmpleadoModel();
            $guardar = $empleadoModel->actualizarRegistro($paramsForm,array('id' => $paramsForm['id']));

            if($guardar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array(
                        'Se actualizo el empleado correctamente'
                    )
                );
            }else{
                $respuesta = array(
                    'success' => false,
                    'msg' => $empleadoModel->getMsgErrors()
                );
                $respuesta['msg'][] = 'No pude actualizar el empleado';
            }
        }else{

            $empleadoModel = new EmpleadoModel();
            $datosFormulario['id'] = 0;
            $guardo = $empleadoModel->insertar($datosFormulario);

            if($guardo){
                $respuesta = array(
                    'success' => true,
                    'data' => array(
                        'id_empleado' => $empleadoModel->ultimoIdInsertado()
                    ),
                    'msg' => array(
                        'Se registro el empleado correctamente'
                    )
                );
            }else{
                $respuesta = array(
                    'success' => false,
                    'msg' => $empleadoModel->getMsgErrors(),
                );
            }
        }

        return $respuesta; */
    }

    public function eliminarEmpleado($empleado) {

        $empleadoModel = new EmpleadoModel();
        $eliminar = $empleadoModel->eliminarRegistro($empleado);
        
        $respuesta = 0;
        return $eliminar;
    }

}