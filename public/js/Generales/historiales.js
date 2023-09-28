 $(document).ready(function(){

    /**
   * Accion que permite obtener los datos del modal de filtros
   * @date  Abr 2020
   * @copyright ZonaNube (zonanube.cl)
   * @author SS
   */
  $('body').on('click', '.btn-buscar-historial', function(){

     // todos los datos
    var historial_completo = $('#inputHiddenTodosHistorial').val();
    // fecha desde cuando se realiza la busqueda
    var historial_fecha_inicio = $('#fechaDesde').val(); 
    // hasta cuando se realiza la busqueda
    var historial_fecha_fin = $('#fechaHasta').val(); 

    var consultar_historial = true;

    $('.msn-input-alert-form-historial').html('');


    if (historial_completo == 0) {

      if (historial_fecha_inicio == '') {

        $('#fechaDesde').addClass('is-invalid');
        consultar_historial = false;

      }

      if (historial_fecha_fin == '') {

        $('#fechaHasta').addClass('is-invalid');
        consultar_historial = false;

      }

      if ( consultar_historial ) {

        // verificacion de fechas
        if (compararFecha(historial_fecha_inicio, historial_fecha_fin)) {

          $('.msn-input-alert-form-historial').html('La fecha Hasta, debe ser mayor que la fecha Desde');
          $('#fechaHasta').addClass('is-invalid');

        }
        else {
          buscarHistorial(historial_completo,historial_fecha_inicio,historial_fecha_fin,modulo_historial,tipo_modulo);
        }

      }else{
         $('.msn-input-alert-form-historial').html('Debe ingresar las fechas para buscar');
      }

    }
    else{

      buscarHistorial(historial_completo,historial_fecha_inicio,historial_fecha_fin,modulo_historial,tipo_modulo);

    }

  });
  
  $('body').on('click', '.link-historial', function(){
    var btn_secundario  =   '<span class="zn-sprite observado"> </span> Cerrar';
    znModalFormulario(2,1,'ajax-request-form-historial', '', 'HISTORIAL DE ACCIONES', 2, '', btn_secundario, 'not-data', 'not-data', 'principal');
  });

  $('body').on('click', '.ico-ver-detalle-historial', function(){

    var historial_id    =   $(this).attr('historial');
    var historial_registro    =   $(this).attr('historial_registro');
    var tiene_listado    =   $(this).attr('tiene_listado');
    var btn_secundario  =   '<span class="zn-sprite observado"> </span> Cerrar';
    var data            =   {historial:historial_id,historial_registro:historial_registro,tiene_listado:tiene_listado};
  
    $(".content-historial").hide();
    $(".content-historial-detalle").html('');
    $(".content-historial-detalle").show();
    ajaxAcciones.consultarDatos(data, 'ajax-buscar-historial-detalle', 'contentHistorialDetalle')
    // modales.abrir('max-w-6xl',2,'ajax-buscar-historial-detalle', data,  'DETALLE HISTORIAL', 2, '', btn_secundario, 'not-data', 'not-data', 'ver-detalle');

    // znModalFormulario(2,2,'ajax-buscar-historial-detalle', data,  'DETALLE HISTORIAL', 2, '', btn_secundario, 'not-data', 'not-data', 'ver-detalle');

  });

  $('body').on('click', '.ico-ver-detalle-historial-listado', function(){

    var historial_id    =   $(this).attr('historial');
    var historial_registro    =   $(this).attr('historial_registro');
    var tiene_listado    =   $(this).attr('tiene_listado');
    var btn_secundario  =   '<span class="zn-sprite observado"> </span> Cerrar';
    var data            =   {historial:historial_id,historial_registro:historial_registro,tiene_listado:tiene_listado};
    modales.abrir('max-w-6xl',2,'ajax-buscar-historial-detalle-listado', data,  'DETALLE HISTORIAL', 2, '', btn_secundario, 'not-data', 'not-data', 'ver-detalle');
    // znModalFormulario(2,2,'ajax-buscar-historial-detalle-listado', data,  'DETALLE HISTORIAL', 2, '', btn_secundario, 'not-data', 'not-data', 'ver-detalle-listado');

  });
  $('body').on('click', '.btn-toggle-inputHiddenTodosHistorial', function(){
    checkToggleHistorial ()
  });
  
  $('body').on('click', '.btn-volver-historial', function(){
    $(".content-sistema").show();
    $(".content-historial").hide();
    $(".sub-sub-modulo-historial").hide();
    
  });
  
  $('body').on('click', '.btn-volver-historial-buscar', function(){
    $(".content-historial").show();
    $(".content-historial-detalle").hide();
  });
  
  $('body').on('click', '.btn-historial-open', function(){
    tamaniosJqGrid('jqGridHistorialAccion');
    $("#jqGridHistorialAccion").jqGrid("clearGridData");
    if ( $("#inputHiddenTodosHistorial").is(':checked') ){
      $("#buscadorHistorialFecha").hide();
    } else {
      $("#inputHiddenTodosHistorial").trigger('click');
    }
    
    $(".content-sistema").hide();
    $(".content-historial").show();
    $(".sub-sub-modulo-historial").show();
    
  });

});


function checkToggleHistorial (){

  if ( $("#inputHiddenTodosHistorial").is(':checked') ){
      $("#inputHiddenTodosHistorial").val(1);
      $("#buscadorHistorialFecha").hide();
      $(".txt-toggle-inputHiddenTodosHistorial").html('Buscar por todo');
  } else {
      $("#inputHiddenTodosHistorial").val(0);
      $("#buscadorHistorialFecha").show();
      $(".txt-toggle-inputHiddenTodosHistorial").html('Buscar por fecha');
  }

}
function formatoDatepicker(texto){
  return texto.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$2-$1-$3');
}

function formatoDateFirefox(texto){
  return texto.replace(/^(\d{2})-(\d{2})-(\d{4})$/g,'$2 $1 $3');
}

function buscarHistorial(historial_completo,historial_fecha_inicio,historial_fecha_fin,modulo_historial,tipo_modulo){

  gestionar_nube();
        
  /** TOKEN @CSRF */
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

  $.ajax({
  type: "POST",
    url: "/ajax-historial",
    data: {
      todos   :   historial_completo,
      desde   :   historial_fecha_inicio,
      hasta   :   historial_fecha_fin,
      modulo_historial  :   modulo_historial,
      tipo    :   tipo_modulo
    }
  }).done(function(response) {
   
    $('.resultado-historial').html(response);
    // $('#fechaDesde').removeClass('is-invalid');
    // $('#fechaHasta').removeClass('is-invalid');
    // $('.msn-input-alert-form-historial').html('');

  }).fail(function(jqXHR, textStatus, errorThrown) {

    gestionar_nube(false);
    /** Contenido muestra de de la alerta */
    if (jqXHR.status === 0){
      modales.alert(1, mensaje_response_error.errConInternet, 'Ok');
    } else if (textStatus === 'timeout') {
        modales.alert(1, mensaje_response_error.errConAplicacion, 'Ok');
    } else {
      modales.alert(1, mensaje_response_error.errBuscar, 'Ok');
    }

  });
}