<?php

class ValidarFormulario{

    public static function validarFormEmpleado($paramsForm){
        $validacion['status'] = true;
        $validacion['msg'] = array();
        if(!isset($paramsForm['clave_empleado']) || $paramsForm['clave_empleado'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'La clave del empleado es requerido';
        }
        if(!isset($paramsForm['nombre']) || $paramsForm['nombre'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El nombre(s) del empleado es requerido';
        }
        if(!isset($paramsForm['edad']) || $paramsForm['edad'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'La edad del empleado es requerido';
        }
        if(!isset($paramsForm['fecha_nacimiento']) || $paramsForm['fecha_nacimiento'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'La fecha de nacimiento del empleado es requerido';
        }
        if(!isset($paramsForm['genero']) || $paramsForm['genero'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El genero del empleado es requerido';
        }
        if(!isset($paramsForm['sueldo_base']) || $paramsForm['sueldo_base'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El sueldo base del empleado es requerido';
        }
        if(!isset($paramsForm['puesto']) || $paramsForm['puesto'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El puesto del empleado es requerido';
        }
        if(!isset($paramsForm['experiencia_profesional']) || $paramsForm['experiencia_profesional'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'La experiencia profesional del empleado es requerido';
        }

        return $validacion;
    }

}