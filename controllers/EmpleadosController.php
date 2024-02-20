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
                    $actualizoEmpleado = $empleadoModel->actualizarRegistro($datosFormTableEmpleado);

                    if($actualizoEmpleado){
                        $empleadoDetalleModel = new DetalleEmpleadoModel($paramsForm['id_empleado']);
                        $actualizoDetalle = $empleadoDetalleModel->actalizarDetalleEmpleadoById($datosFormTableDetalleEmpleado);
                        
                        if($actualizoDetalle){
                            $respuesta = array(
                                'success' => true,
                                'msg' => array(
                                    'Se actualizó el empleado correctamente'
                                )
                            );
                        }
                    }else{
                        $respuesta = array(
                            'success' => false,
                            'msg' => 'No se pudo actualizar el empleado'
                        );
                    }
                }else{
                    $empleadoModel = new EmpleadoModel();
                    $datosFormTableEmpleado["activo"] = 1;
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
                                    'Se registró el empleado correctamente'
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

    public function obtenerMoneda() {
        try {
            $url = 'https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF343410/datos/oportuno';
            $token = 'b1f35fb18770e6b7d3f9dedfedf8d38a96f3224a8533934ad87623a1826c7b1f';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Bmx-Token: ' . $token,
                'Accept: application/json'
            ));

            $response = curl_exec($ch);

            $data = json_decode($response, true);

            if ($data !== null && isset($data['bmx']['series'][0]['datos'][0]['dato'])) {
                $tipo_cambio = $data['bmx']['series'][0]['datos'][0]['dato'];

                $respuesta = array(
                    'success' => true,
                    'data' =>  $tipo_cambio,
                    'msg' => array(
                        'Se obtuvo el cambio de moneda correctamente'
                    )
                );
            } else {
                $respuesta = array(
                    'success' => false,
                    'msg' => array(
                        'Error al obtener el tipo de cambio'
                    )
                );
            }

            curl_close($ch);

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