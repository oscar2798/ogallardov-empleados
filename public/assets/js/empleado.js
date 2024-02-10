var host_backend = 'http://localhost/ogallardov/routes/rutas.php?';

$(document).ready(function () {

    $(document).on('click','#btnAgregarEmpleado',function(){
        $('#formEmpleado').fadeIn();
        $('#tablaEmpleados').fadeOut();
        
        $('#tituloFormEmpleado').html('Registrar un empleado');
        $('#formEmpleado')[0].reset();
        $('#inputIdEmpleado').val(0);
    });

    $(document).on('click','#btnGuardarEmpleado',function(){
        Empleados.guardarEmpleado();
    });

    $(document).on('click','#btnCancelarEmpleado',function(){
        $('#contenedorFormEmpleado').fadeOut();
        $('#tablaEmpleados').fadeIn();
    });

    //para el boton de modificar
    $(document).on('click','.btnModificarEmpleado',function(){
        var botonModificar = $(this);
        $('#contenedorFormEmpleado').fadeIn();
        $('#tablaEmpleados').fadeOut();
        //llamar la funcion del js de catalogo -> obtener estado
        //Catalogos.obtener_catalogo_estado();
        $('#tituloFormEmpleado').html('Modificar empleado');
        var empleado = JSON.parse(atob(botonModificar.data('str_empleado_obj')));
        $('#inputIdEmpleado').val(empleado.id);
        $('#inputClave').val(empleado.clave);
        $('#inputNombre').val(empleado.nombres);
        $('#inputPaterno').val(empleado.apellido_paterno);
        $('#inputMaterno').val(empleado.apellido_materno);
        $('#inputDireccion').val(empleado.direccion);
        $('#sltInputEstado').val(empleado.catalogo_estado_id);
    });

    //para abrir la modal
    $(document).on('click','.btnAgregarDatosContacto',function (){
        var botonModificar = $(this);
        $('#tbodyDatosContactoEmpleado').html('');
        var id_empleado = botonModificar.data('id_empleado');

        var nombre_empleado = botonModificar.data('nombre_empleado');
        var datosContacto = JSON.parse(atob(botonModificar.data('datos_contacto')));
        var html = '';
        datosContacto.forEach(function(item) {
            html = '<tr>' +
            '<td>' +
            '<select class="form-select slt_cat_contacto" id="slt_contacto_'+id_empleado+'_'+item.id+'">' +
                Catalogos.html_catalogo_contacto +
            '</select>' +
            '</td>' +
            '<td><input type="text" class="form-control" id="slt_input_contacto'+id_empleado+'_'+item.id+'" placeholder="Dato de contacto"></td>' +
            '<td>' +
                '<button type="button" class="btn btn-danger">eliminar</button>' +
            '</td>' +
        '</tr>';
        $('#tbodyDatosContactoEmpleado').append(html);
        $('#slt_contacto_'+id_empleado+'_'+item.id).val(item.catalogo_contacto_id);
        $('#slt_input_contacto'+id_empleado+'_'+item.id).val(item.dato_contacto);
        });
        $('#nombreEmpleado').html(nombre_empleado);
        //alert(nombre_empleado);
    });

    $(document).on('click','#agregarDatoContacto',function (){
        var html = '<tr>' +
                '<td>' +
                '<select class="form-select slt_cat_contacto">' +
                    Catalogos.html_catalogo_contacto +
                '</select>' +
                '</td>' +
                '<td><input type="text" class="form-control" placeholder="Dato de contacto"></td>' +
                '<td>' +
                    '<button type="button" class="btn btn-danger">eliminar</button>' +
                '</td>' +
            '</tr>';
        $('#tbodyDatosContactoEmpleado').append(html);
    });


    $(document).on('click','.btnEliminarEmpleado',function(){
        var botonEliminar = $(this);
        var empleado = JSON.parse(atob(botonEliminar.data('str_empleado_id')));

        Swal.fire({
            title: '¡Espera!',
            text: "¿Estas seguro/a de eliminar al empleado?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
          }).then((result) => {
            if (result.isConfirmed) {
                Empleados.eliminarEmpleado(empleado);
            }
          })
    });

    Empleados.listaEmpleados();

});

var Empleados = {

    listaEmpleados : function(){
        $('#listaEmpleados').html('<tr><td colspan="5" class="text-center">Cargando...</td></tr>');
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=listado',
            data : {},
            dataType : 'json',
            success : function (respuestaAjax){
                console.log(respuestaAjax);
                if(respuestaAjax.success) {
                    var html_registros_empleados = '';
                    respuestaAjax.data.empleados.forEach(function(empleado){
                        var strEmpleadoObj = btoa(JSON.stringify(empleado));
                        
                        html_registros_empleados += '<tr>' +
                                '<td>'+empleado.clave_empleado+'</td>' +
                                '<td>'+empleado.nombre+'</td>' +
                                '<td>'+empleado.edad+'</td>' +
                                '<td>'+empleado.fecha_nacimiento+'</td>' +
                                /* '<td>'+
                                    '<button type="button" class="btn btn-secondary btnAgregarDatosContacto" ' +
                                    'data-bs-toggle="modal" data-bs-target="#modalFormDatosContacto"' +
                                    'data-id_empleado="'+empleado.id+'" data-nombre_empleado="'
                                    +empleado.nombres+'">Visualizar datos</button>'+
                                '</td>' + */
                                '<td>' +
                                    '<button data-str_empleado_obj="'+strEmpleadoObj+'"' +
                                        'class="button is-warning btnModificarEmpleado" style="margin-right: 10px;">Modificar</button>' +

                                    '<button data-id_empleado_eliminar="'+empleado.id_empleado+'" ' +
                                    'class="button is-danger btnEliminarEmpleado" id="id_empleado_delete'+empleado.id_empleado+'" data-str_empleado_id="'+strEmpleadoObj+'">Eliminar</button>' +
                                '</td>' +
                            '</tr>';
                    });
                    $('#listaEmpleados').html(html_registros_empleados);
                }
            },error : function (err){
                Swal.fire({
                    title: "Error en la petición de empleados",
                    icon: "error"
                });
            }
        });
    },

    guardarEmpleado : function(){
        $.ajax({
            type : 'post', //tipo
            url : host_backend+'peticion=empleados&funcion=agregar-actualizar',
            
            data : $('#formEmpleado').serialize(),
            dataType : 'json',
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    $('#contenedorFormEmpleado').fadeOut();
                    $('#tablaEmpleados').fadeIn();
                    Empleados.listadoEmpleados();
                }else{
                    var html_mensajes = '';
                    respuestaAjax.msg.forEach(function(mensaje){
                        html_mensajes += '<li>'+mensaje+'</li>';
                    });
                    $('#divMensajesSistema').html(html_mensajes).fadeIn();
                    setTimeout(function(){
                        $('#divMensajesSistema').html('').fadeOut();
                    },10000);
                }
            },error : function (err){
                Empleados.alertaError("Error en la petición de guardar empleado");
            }
        });
    },

    eliminarEmpleado: function(empleado) {
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=eliminar',
            data : empleado,
            dataType : 'json',
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        'Se elimino el empleado correctamente',
                        'success'
                      )
                    Empleados.listaEmpleados();
                }else{
                    var html_mensajes = '';
                    respuestaAjax.msg.forEach(function(mensaje){
                        html_mensajes += '<li>'+mensaje+'</li>';
                    });
                    $('#divMensajesSistema').html(html_mensajes).fadeIn();
                    setTimeout(function(){
                        $('#divMensajesSistema').html('').fadeOut();
                    },10000);
                }
                
            },error : function (err){
                Empleados.alertaError('Error en la petición de eliminar empleado');
            }
        });
    },

    alertaError: function(mensaje) {
        Swal.fire({
            title: mensaje,
            icon: "error"
        });
    }
    
}
