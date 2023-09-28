/**
 * variable que contiene las funciones principales para apertura y configuracion de modal
 * @date 18-08-2023
 * @copyright Zona Nube
  @author RP
 */

function limpiarBotonEntendido () {
    $('#btn-modal-success').attr('class', ''); 
    $('#btn-modal-success').attr('class', 'zn-boton-success-modal text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2'); 
    // $('.contenedor-btn-primario').html('<button id="btn-modal-success" data-modal-hide="zn-modal-mensajes" type="button" class="zn-boton-success-modal text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2"></button>'); 
}
var modales = function() {
    function mostrarModal(id = '', contenido = '', boton_primario = '', boton_secundario = '', titulo = '', accion_form = '', size = 'max-w-6xl', clase_accion, footer = false) {
        $( "div" ).remove( '#contenedor-'+id );
        if (! $('#contenedor-'+id).length ) {
            $('body').append('<div id="contenedor-'+id+'" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"');
        }
        //// Clase segun tamaño de modal
        let modal_size = {
                    1: '',
                    2: 'modal-xl',
                    3: 'modal-lg',
                    4: '',
                    5: 'modal-lg'
        }

        $('#contenedor-'+id).html('\
            <button id="btn-cargar-'+id+'" data-modal-target="contenedor-'+id+'" data-modal-toggle="contenedor-'+id+'" class="block hidden" type="button"></button>\
            <div class="relative w-full '+size+' max-h-full">\
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">\
                    <div class="flex items-start justify-between px-4 py-2 border-b rounded-t dark:border-gray-600">\
                        <h3 class="text-lg pt-1 font-semibold text-gray-900 dark:text-white">\
                            '+titulo+'\
                        </h3>\
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="contenedor-'+id+'">\
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">\
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>\
                            </svg>\
                            <span class="sr-only">Cerrar</span>\
                        </button>\
                    </div>\
                    <div class="p-6 space-y-6 max-w-3xl modal-body-'+id+'">\
                        '+contenido+'\
                    </div>\
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">\
                        <button data-modal-hide="contenedor" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cerrar</button>\
                    </div>\
                </div>\
            </div>');

        // Recargar Si es login
        try {
          variable_recargar_login;
          window.location.reload();
        } catch {
        }

        gestionar_nube(false);
        $('#btn-cargar-'+id).trigger( 'click' );
    }

    function modalAlerta (icon, contenido, btnSucces='Ok', btnError=null, funcion = null) {
        
        limpiarBotonEntendido();
        if ( icon == 0 ){
            $( ".modal-icon-success" ).show();
            $( ".modal-icon-error" ).hide();
            $( ".modal-icon-alert" ).hide();
            $( ".modal-icon" ).hide();
        } else if( icon == 1 ){
            $( ".modal-icon-error" ).show();
            $( ".modal-icon-success" ).hide();
            $( ".modal-icon-alert" ).hide();
            $( ".modal-icon" ).hide();
        } else if( icon == 3 ) {
            $( ".modal-icon-alert" ).show();
            $( ".modal-icon-success" ).hide();
            $( ".modal-icon-error" ).hide();
            $( ".modal-icon" ).hide();
        } else {
            $( ".modal-icon" ).show();
            $( ".modal-icon-alert" ).hide();
            $( ".modal-icon-success" ).hide();
            $( ".modal-icon-error" ).hide();
        }

        if ( btnError != null ) {
            $( "#btn-modal-close" ).show();
            $( "#btn-modal-close" ).html(btnError);
        } else {
            $( "#btn-modal-close" ).hide();
            $( "#btn-modal-close" ).html('Cancelar');
        }
        
        $( "#btn-modal-success" ).html(btnSucces);
        $( "#zn-contenido-modal" ).html(contenido);

        if ( funcion != null && typeof window[funcion] === "function" ) {
            window[funcion]();
        }

        $( "#btn-modal-mensajes" ).trigger( "click" );

    }

    return {
        alert: function(icon, contenido, btnSucces='Ok', btnError=null, funcion = null) {
            modalAlerta(icon, contenido, btnSucces, btnError, funcion);
        },
        abrir: function (modal_lg, nivel, url, send_data, titulo, btn_view, btn_primario, btn_secundario, clase_accion, accion_form, idModal, footer) {
            
            gestionar_nube();
            /** TOKEN @CSRF */
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            let url_ajax = dominio_app+'/'+url
            $.ajax({
            type: "POST",
                url: url_ajax,
                data: send_data
            }).done(function(response) {

                mostrarModal(idModal, response, btn_primario, btn_secundario, titulo, accion_form, modal_lg, clase_accion, footer);
                

            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0){
                    modales.alert(1, mensaje_response_error.errConInternet, 'Ok');
                } else if (textStatus === 'timeout') {
                    modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
                } else {
                    modales.alert(1, mensaje_response_error.errBuscar, 'Ok');
                }
            });
            return 0;
        },
        cerrar: function(id = '') {
            $('#'+id).modal('hide');
            // $('#'+id).dialog('close');
        },
        cerrarDefinitivo: function() { 
            var cierre = $('#cierre-modal').val();
            modales.cerrar('contenedor-alerta');
            if (cierre == 1) {
                var id_cierre = $('#cierre-modal').attr('ventana-cerrar');
                $('#cierre-modal').removeAttr('ventana-cerrar');
                modales.cerrar(id_cierre);
            }
        },
        prepararCierre: function (id = '') {
            $("#cierre-modal").val(1);
            $("#cierre-modal").attr("ventana-cerrar", id);
        },
        validar: function(id = '') {
            if ($("#cierre-modal").val() == 1) {
                $("#cierre-modal").val(0);
                return true;
            } else {
                var campos_form = $("#"+id).attr('form-campos-edit');
                var cerrar_formulario     = 1;

                $('.comprobar-'+campos_form).each(function(){

                    var id_campo =    $(this).attr('id');
                    var valor_original = $(this).attr('value-original');
                    var valor_campo = $(this).val();

                    valor_campo = (valor_campo == null ? '' : valor_campo);

                    if (id_campo != undefined) {

                        // console.log('id_campo: '+id_campo);
                        // console.log('valor_original: '+valor_original);
                        // console.log('valor_campo: '+valor_campo);

                        if (valor_original != valor_campo) {
                            cerrar_formulario = 2;
                        }
                    }

                });

                if( cerrar_formulario == 1) {
                    return true;
                } else {
                    modales.prepararCierre(id);
                    modales.alert('CONFIRMAR', 'mensaje-warning', mensaje_response_question.quesCerrar, 'SI', 'NO', 0, 480, 0, 0, 0);
                    return false;
                }
            }
        },
        modalDescripcion: function(id = '', contenido = '', boton_primario = '', boton_secundario = '', titulo = '', accion_form = '', size = 1, clase_accion) {
            mostrarModal(id, contenido, boton_primario, boton_secundario, titulo, accion_form , size, clase_accion);
        }
    }
}();


var modalAcciones = function() {

    return {
        registrar: function (formulario, tipo, url, idJQGrid='', urlDestino='', errorMensaje, cierre = 1, idJQGrid2='') {
            /** Se obtienen los datos del formulario */
            let miForm = document.getElementById(formulario);
            let data = new FormData(miForm);
            data.append('tipo', tipo);

            /** TOKEN @CSRF */
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            let url_ajax = dominio_app+'/'+url
            $.ajax({
                type: "POST",
                url: url_ajax,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
            }).done(function(response) {
                gestionar_nube(false);
                
                if (response.error == 1) {

                    modales.alert(3, mensaje_response_warning.default, 'Ok');

                } else if (response.success.error == 1) {
                    
                    modales.alert(1, response.response, 'Ok');

                } else if (response.success.error == 0) {

                    if (urlDestino != '') {
                        $('.btn-entendido').removeAttr('data-dismiss');
                        $('.btn-entendido').addClass('ir-pagina');
                        $('.btn-entendido').attr('urlDestino', urlDestino);
                    }
                    modales.alert(0, response.success.mensaje, 'Ok');

                if (idJQGrid != '') {

                    $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    var tabla = $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    tabla[0].clearToolbar();

                }

                if (idJQGrid2 != '') {

                    $("#"+idJQGrid2).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    var tabla2 = $("#"+idJQGrid2).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    tabla2[0].clearToolbar();

                }

              }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0) {

                    modales.alert(1, mensaje_response_error.errConInternet, 'Ok');

                }else if (textStatus === 'timeout') {

                    modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
                
                } else {

                    if ( errorMensaje == 'errGuardar') {
                        var response_error = mensaje_response_error.errGuardar
                    } else if ( errorMensaje == 'errActualizar') {
                        var response_error = mensaje_response_error.errActualizar
                    }
                    modales.alert(1, response_error, 'Ok');
                }
            });
        },
        registrarDatos: function (formulario, tipo, url, idJQGrid, urlDestino, errorMensaje, cierre = 1) {
            /** Se obtienen los datos del formulario */
            var datos_formulario = obtenerDatosFormulario(formulario, tipo);

            /** TOKEN @CSRF */
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            let url_ajax = dominio_app+'/'+url
            $.ajax({
                type: "POST",
                url: url_ajax,
                data: datos_formulario
            }).done(function(response) {
                gestionar_nube(false);

                var id_modal = $('#btn-modal-accion').attr('contenedor');
                if (response.error == 1) {
                    irCabeceraScrollElemento(id_modal);
                    modales.alert('ADVERTENCIA', 'mensaje-warning', mensaje_response_warning.default, 'OK', '', 1,0,0,0);

                } else if (response.success.error == 1) {
                    irCabeceraScrollElemento(id_modal);
                    $('#'+response.success.error_input).addClass('is-invalid');
                    modales.alert('ERROR', 'mensaje-error', response.success.mensaje, 'OK', '', 1, 0,0,0);

                } else if (response.success.error == 0) {

                    $("#cierre-modal").val(1);
                    if (cierre == 1) modales.cerrar(id_modal);
                    if (urlDestino != ''){
                        $('.btn-entendido').removeAttr('data-dismiss');
                        $('.btn-entendido').addClass('ir-pagina');
                        $('.btn-entendido').attr('urlDestino', urlDestino);
                    }
                    modales.alert('FINALIZADO', 'mensaje-success', response.success.mensaje, 'OK', '', 1, 320,-12,25);

                if (idJQGrid != '') {

                    $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    var tabla = $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    tabla[0].clearToolbar();

                }
              }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0) {

                    modales.alert('ERROR', 'mensaje-error', mensaje_response_error.errConInternet, 'OK', '', 1,0,0,0);

                }else if (textStatus === 'timeout') {

                    modales.alert('ERROR', 'mensaje-error', mensaje_response_error.errConAplicacion, 'OK', '', 1,0,0,0);

                } else {

                    if ( errorMensaje == 'errGuardar') {
                        var response_error = mensaje_response_error.errGuardar
                    } else if ( errorMensaje == 'errActualizar') {
                        var response_error = mensaje_response_error.errActualizar
                    }
                    modales.alert('ERROR', 'mensaje-error',response_error, 'OK', '', 1,0,0,0);
                }
            });
        },

        borrar: function (modulo_id, url, idJQGrid, idJQGrid2 = '') {

            gestionar_nube();

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    data : modulo_id,
                }
            }).done(function(response) {

                gestionar_nube(false);

                if ( response.error == 1 ) {
                    /** Contenido muestra de la alerta */
                    modales.alert(1, mensaje_response_error.errBorrar, 'Ok');
                } else if ( response.success.error == 1 ) {
                    /** Contenido muestra de la alerta */
                    modales.alert(1, response.success.mensaje, 'Ok');
                } else if ( response.success.error == 0 ) {
                    /** Contenido muestra de la alerta */
                    modales.alert(0, response.success.mensaje, 'Ok');
                    $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    var tabla = $("#"+idJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                    tabla[0].clearToolbar();
                    
                    if (idJQGrid2 != "") {
                        $("#"+idJQGrid2).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                        var tabla2 = $("#"+idJQGrid2).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
                        tabla2[0].clearToolbar();
                    }
                }

            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0) {
                    modales.alert(1, mensaje_response_error.errConInternet, 'Ok');
                } else if (textStatus === 'timeout') {
                    modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
                } else {
                    modales.alert(1, mensaje_response_error.errBorrar, 'Ok');
                }
            });
        }
    }
}();


var ajaxAcciones = function() {

    return {
        consultar: function (formulario, tipo, url, capa, errorMensaje, urlDestino='') {
            /** Se obtienen los datos del formulario */
            let miForm = document.getElementById(formulario);
            let data = new FormData(miForm);
            data.append('tipo', tipo);

            /** TOKEN @CSRF */
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

            let url_ajax = dominio_app+'/'+url
            $.ajax({
                type: "POST",
                url: url_ajax,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data'
            }).done(function(response) {

                $("#" + capa).html(response);


            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0) {
                    modales.alert(1, mensaje_response_error.errConInternet, 'Ok');
                } else if (textStatus === 'timeout') {
                    modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
                } else {
                    modales.alert(1, mensaje_response_error.errBuscar, 'Ok');
                }
            });
        },
        consultarDatos: function (data, url, capa) {
            /** Se obtienen los datos del formulario */

            let url_ajax = dominio_app+'/'+url
            $.ajax({
                type: "POST",
                url: url_ajax,
                data: {
                    data : data,
                }
            }).done(function(response) {
                gestionar_nube(false);

                $("#" + capa).html(response);

            }).fail(function(jqXHR, textStatus, errorThrown) {
                gestionar_nube(false);
                /** Contenido muestra de la alerta */
                if (jqXHR.status === 0) {
                    modales.alert(1, mensaje_response_error.errConInternet, 'Ok');
                } else if (textStatus === 'timeout') {
                    modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
                } else {
                    modales.alert(1, mensaje_response_error.errBuscar, 'Ok');
                }
            });
        }
    }
}();