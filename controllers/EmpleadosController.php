<?php 

include_once("../models/EmpleadoModel.php");
include_once("../models/DetalleEmpleadoModel.php");
include_once("../helper/validarFormulario.php");
class EmpleadosController {

    public function obtenerEmpleados() {
        $empleadoModel = new EmpleadoModel();
        $listaEmpleados = $empleadoModel->obtenerRegistros();

        foreach ($listaEmpleados as $key => $empleado) {
            $detalleEmpleadoModel = new DetalleEmpleadoModel($empleado['id_empleado']);
            $detalleEmpleado = $detalleEmpleadoModel->obtenerDetalleEmpleadoById();
            $empleado['detalle'] = $detalleEmpleado;
            $empleadoCompleto[$key] = $empleado;
        }

        $respuesta = array(
            'success' => true,
            'data' => array(
                'empleados' => $empleadoCompleto
            )
        );
        return $respuesta;
    }

    public function guardarEmpleado($paramsForm) {
        try{
            
            $validacion = ValidarFormulario::validarFormEmpleado($paramsForm);

            foreach ($paramsForm as $columna => $value) {
                if ($columna !== 'puesto' && $columna !== 'experiencia_profesional') {
                    $datosFormTableEmpleado[$columna] = $value; 
                } else {
                    $datosFormTableDetalleEmpleado[$columna] = $value;
                }
            }

            if($validacion['status']){
                if(isset($paramsForm['id_empleado']) && !empty($paramsForm['id_empleado'])){
                    $empleadoModel = new EmpleadoModel();
                    
                    $guardar = $empleadoModel->actualizarRegistro($datosFormTableEmpleado);

                    if($guardar){
                        $respuesta = array(
                            'success' => true,
                            'msg' => array(
                                'Se actualizó el empleado correctamente'
                            )
                        );
                    }else{
                        $respuesta = array(
                            'success' => false,
                            'msg' => 'No se pudo actualizar el empleado'
                        );
                    }
                }else{
                    $empleadoModel = new EmpleadoModel();
                    
                    $guardoEmpleado = $empleadoModel->agregarRegistro($datosFormTableEmpleado);

                    if($guardoEmpleado){
                        $empleadoDetalleModel = new DetalleEmpleadoModel();

                        $datosFormTableDetalleEmpleado['empleado_id'] = $empleadoModel->ultimoIdInsertado();
                        $guardoDetalle = $empleadoDetalleModel->agregarRegistro($datosFormTableDetalleEmpleado);

                        if($guardoDetalle){
                            $respuesta = array(
                                'success' => true,
                                'data' => array(
                                    'id_empleado' => $empleadoModel->ultimoIdInsertado()
                                ),
                                'msg' => array(
                                    'Se registro el empleado correctamente'
                                )
                            );
                        }
                        
                    }else{
                        $respuesta = array(
                            'success' => false,
                            'msg' => 'No se pudo registrar el empleado correctamente',
                        );
                    }
                }
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $validacion['msg'];
            }
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    'Ocurrio un error en el servidor, intentelo más tarde',
                    ''. $guardoDetalle,
                    $ex->getMessage()
                )
            );
        }
        return $respuesta;
    }

    public function eliminarEmpleado($idEmpleado) {
        try {
            $empleadoModel = new EmpleadoModel();
            $eliminar = $empleadoModel->eliminarRegistro($idEmpleado);
            if($eliminar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array(
                        'Se eliminó el empleado correctamente'
                    )
                );
            }else{
                $respuesta = array(
                    'success' => false,
                    'msg' => 'No se pudo eliminar el empleado'
                );
            }
        } catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    'Ocurrio un error en el servidor, intentar mas tarde',
                    $ex->getMessage()
                )
            );
        }
        return $respuesta;
    }

}