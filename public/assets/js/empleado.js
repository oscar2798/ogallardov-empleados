var host_backend = 'http://localhost/ogallardov/routes/rutas.php?';

$(document).ready(function () {

    $(document).on('click','#btnAgregarEmpleado',function(){
        $('#contenedorFormEmpleado').fadeIn();
        $('#campoActivoInactivo').fadeOut();
        $('#tablaEmpleados').fadeOut();
        
        $('#tituloFormEmpleado').html('Agregar empleado');
        $('#tituloBtnFormEmpleado').html('Registrar');
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

    $(document).on('click','#btnRegresar',function(){
        $('#contenedorDetalleEmpleado').fadeOut();
        $('#tablaEmpleados').fadeIn();
    });

    $(document).on('click','.btnVerDetalleEmpleado',function (){
        var botonDetalle = $(this);
        $('#contenedorDetalleEmpleado').fadeIn();
        $('#tablaEmpleados').fadeOut();
        
        var empleado = JSON.parse(atob(botonDetalle.data('str_empleado_obj')));
    
        $('#inputDetalleClave').val(empleado.clave_empleado);
        $('#inputDetalleNombre').val(empleado.nombre);
        $('#inputDetalleEdad').val(empleado.edad);
        $('#inputDetalleFecha').val(empleado.fecha_nacimiento);
        $('#inputDetalleGenero').val(empleado.genero);
        $('#inputDetalleSueldo').val(Number(empleado.sueldo_base).toLocaleString('en-US'));
        $('#inputDetalleActivoInactivo').val((empleado.activo == 1 ? 'Activo' : 'Inactivo'));
        $('#inputDetallePuesto').val(empleado.detalle?.puesto);
        $('#inputDetalleExperiencia').val(empleado.detalle?.experiencia_profesional);
     
        var aumento = Number(empleado.sueldo_base) * 0.04;
        var primeros4meses = Number(empleado.sueldo_base) + aumento;

        var primeros8meses = primeros4meses + aumento;

        var primeros12meses = primeros8meses + aumento;

        var primeros16meses = primeros12meses + aumento;

        var primeros18meses = primeros16meses + aumento;

        var dataAumentoPesos = [
            Number(primeros4meses.toFixed(2)), 
            Number(primeros8meses.toFixed(2)), 
            Number(primeros12meses.toFixed(2)), 
            Number(primeros16meses.toFixed(2)),
            Number(primeros18meses.toFixed(2))
        ];

        Empleados.apiBanxico(dataAumentoPesos);

    });

    $(document).on('click','.btnModificarEmpleado',function(){
        var botonModificar = $(this);
        $('#contenedorFormEmpleado').fadeIn();
        $('#tablaEmpleados').fadeOut();
       
        $('#tituloFormEmpleado').html('Modificar empleado');
        $('#tituloBtnFormEmpleado').html('Actualizar');
        var empleado = JSON.parse(atob(botonModificar.data('str_empleado_obj')));

        $('#inputIdEmpleado').val(empleado.id_empleado);
        $('#inputClave').val(empleado.clave_empleado);
        $('#inputNombre').val(empleado.nombre);
        $('#inputEdad').val(empleado.edad);
        $('#inputFecha').val(empleado.fecha_nacimiento);
        $('#inputGenero').val(empleado.genero);
        $('#inputSueldo').val(empleado.sueldo_base);
        $('#inputActivoInactivo').val(empleado.activo);
        $('#inputPuesto').val(empleado.detalle?.puesto);
        $('#inputExperiencia').val(empleado.detalle?.experiencia_profesional);
    });

    $(document).on('click','.btnEliminarEmpleado',function(){
        var botonEliminar = $(this);
        var idEmpleado = botonEliminar.data('id_empleado_eliminar');

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
                Empleados.eliminarEmpleado(idEmpleado);
            }
          })
    });

    Empleados.listaEmpleados();

});

var graficaPesos;
var graficaDolares;

var Empleados = {

    listaEmpleados : function(){
        $('#listaEmpleados').html('<tr><td colspan="5" class="text-center">Cargando...</td></tr>');
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=listado',
            data : {},
            dataType : 'json',
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    var html_registros_empleados = '';
                    respuestaAjax.data.empleados.forEach(function(empleado){
                        var strEmpleadoObj = btoa(JSON.stringify(empleado));
                        var fecha_nacimiento = new Date(empleado.fecha_nacimiento).toLocaleDateString();
                        html_registros_empleados += '<tr>' +
                                '<td>'+empleado.clave_empleado+'</td>' +
                                '<td>'+empleado.nombre+'</td>' +
                                '<td>'+empleado.edad+'</td>' +
                                '<td>'+fecha_nacimiento+'</td>' +
                                '<td>'+(empleado.activo == true ? 'Activo' : 'Inactivo') +'</td>' +
                                '<td>'+
                                    '<button class="button is-info js-modal-trigger btnVerDetalleEmpleado" ' +
                                    'data-str_empleado_obj="'+strEmpleadoObj+'">Ver</button>'+
                                '</td>' +
                                '<td>' +
                                    '<button data-str_empleado_obj="'+strEmpleadoObj+'"' +
                                        'class="button is-warning btnModificarEmpleado" style="margin-right: 10px;">Modificar</button>' +
                                    (empleado.activo == 1 ?
                                    '<button data-id_empleado_eliminar="'+empleado.id_empleado+'" ' +
                                    'class="button is-danger btnEliminarEmpleado" id="id_empleado_delete'+empleado.id_empleado+'" '+
                                    'data-str_empleado_id="'+strEmpleadoObj+'">Eliminar</button>' : 
                                    '<button class="button is-danger" disabled>Eliminar</button>') +
                                '</td>' +
                            '</tr>';
                    });
                    $('#listaEmpleados').html(html_registros_empleados);
                }
            },error : function (err){
                Empleados.alertaError("Error en la petición de empleados")
            }
        });
    },

    guardarEmpleado : function(){
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=agregar-actualizar',
            data : $('#formEmpleado').serialize(),
            dataType : 'json',
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    $('#contenedorFormEmpleado').fadeOut();
                    $('#tablaEmpleados').fadeIn();
                    Empleados.alertaExito(respuestaAjax.msg);
                    Empleados.listaEmpleados();
                }else{
                    var html_mensajes = '';
                    respuestaAjax.msg.forEach(function(mensaje){
                        html_mensajes += '<li>'+mensaje+'</li>';
                    });

                    Swal.fire({
                        html: html_mensajes,
                        icon: "info"
                    });
                }
            },error : function (err){
                console.log(err);
                Empleados.alertaError("Error en la petición de guardar empleado");
            }
        });
    },

    eliminarEmpleado: function(idEmpleado) {
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=eliminar',
            data : {idEmpleado: idEmpleado},
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

    apiBanxico(datosGraficaPesos) {
        $.ajax({
            type : 'POST',
            url : host_backend+'peticion=empleados&funcion=banxico',
            data : {},
            dataType : 'json',
            success : function (respuestaAjax){
                if(respuestaAjax.success) {

                     // 1 dolar a pesos = 17.0419
                     // 1 peso a dolar = 0.059

                    var dolarPeso = respuestaAjax.data;

                    var datosAumentoDolares = [];

                    datosGraficaPesos.forEach(salario => {

                        var pesoDolar = salario / Number(dolarPeso);

                        datosAumentoDolares.push(pesoDolar)
                    });

                    Empleados.graficaProyeccionPesos(datosGraficaPesos);

                    Empleados.graficaProyeccionDolares(datosAumentoDolares);

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
                console.log(err);
                Empleados.alertaError('Error en la petición de eliminar empleado');
            }
        });
    },

    graficaProyeccionPesos(dataAumento) {
        const ctx = document.getElementById('graficaPesos').getContext("2d");

        if (graficaPesos) {
            grafica.destroy();
        }

        graficaPesos = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['4 Meses', '8 Meses', '12 Meses', '16 Meses', '18 Meses'],
                datasets: [
                    {
                        label: 'Total MXN',
                        data: dataAumento,
                        borderWidth: 1,
                        backgroundColor: [
                           '#ff6384',
                            '#36a2eb',
                            '#cc65fe',
                            '#ffce56'
                        ]
                    },
                ]
            },
            
        });
    },

    graficaProyeccionDolares(dataAumento) {
        const ctx = document.getElementById('graficaDolares').getContext("2d");

        if (graficaDolares) {
            grafica.destroy();
        }

        graficaDolares = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['4 Meses', '8 Meses', '12 Meses', '16 Meses', '18 Meses'],
                datasets: [
                    {
                        label: 'Total USD',
                        data: dataAumento,
                        borderWidth: 1,
                        backgroundColor: [
                           '#ff6384',
                            '#36a2eb',
                            '#cc65fe',
                            '#ffce56'
                        ]
                    },
                ]
            },
            
        });
    },

    alertaError: function(mensaje) {
        Swal.fire({
            title: mensaje,
            icon: "error"
        });
    },

    alertaExito: function(mensaje) {
        Swal.fire({
            title: mensaje,
            icon: "success"
        });
    }
    
}