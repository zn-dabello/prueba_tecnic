realoadJQgrid_direcciones = false;

function cargarGrilla () {
	/**
   * Accion que permite cargar la lista de direcciones
   * @date    10-08-2023
   * @copyright ZonaNube (zonanube.cl)
   * @author RP
   */
    // Cabecera de la tabla
    var colNames_usuarios = ['', '', '', 'Estado', '', '', 'Fecha de Mantención', 'Número de Equipo', 'Marca de Equipo', 'Ubicación', 'Proveedor'];
    // Indicadores de cada item de la tabla
    var colModel_usuarios = [
        { name: 'borrar', width: 40, align: 'center', sortable: false, search: false },
        { name: 'editar', width: 40, align: 'center', sortable: false, search: false },
        { name: 'ver', width: 40, align: 'center', sortable: false, search: false },
        { name: 'estado', width: 140, stype: 'select', searchoptions: { value: tipo_estados }, index: "estado_min" },
        { name: 'estado_min', hidden: true },
        { name: 'estado_pnt', width: 34, align: 'center', sortable: false, search: false },
        { name: 'fecha_mantencion', width: 100 },
        { name: 'numero_equipo', width: 100 },
        { name: 'marca_equipo', width: 100 },
        { name: 'ubicacion', width: 100 },
        { name: 'proveedor', width: 100 },
    ];

    var load_table = znLoadJQgrid(1080, realoadJQgrid_direcciones, 'jqGridRegistro', 'jqGridPagerRegistrarse', 'ajax-request-registrarse', colNames_usuarios, colModel_usuarios);
    if (load_table){
      realoadJQgrid_direcciones = true;
    }
    //perfiles visualizadores
    $("#jqGridRegistro").bind("jqGridAfterGridComplete", function () {

    });
}


function validarFormularioRegistro (formulario) {

  gestionar_nube();
  var formulario_valido = true;
  var mostrar_modal = false;

  if (camposObligatorios(formulario) == 0) {
      mostrar_modal = true;
      formulario_valido = false;
  }


  if( mostrar_modal ) {
    gestionar_nube(false);
    modales.alert(3, mensaje_response_warning.default, 'Ok');
  }

  return formulario_valido;

}

let registro;
function agregarClasesEliminar () {
  $('#btn-modal-success').removeAttr('data-modal-hide');
  $('#btn-modal-success').addClass('borrar-registro');
  $('#btn-modal-success').attr('registro', registro);
}


function checkToggleDireccion () {

  if ( $("#inputEstados").is(':checked') ){
      $("#inputEstados").val(1);
      $("#inputEstado").val(1);
      $(".txt-toggle-inputEstados").html('Activo');
  } else {
      $("#inputEstados").val(0);
      $("#inputEstado").val(0);
      $(".txt-toggle-inputEstados").html('Inactivo');
  }

}

$(document).ready(function(){

  $('body').on('click', '#jqGridRegistro .icon-ver-registro', function () {
      var registro   = $(this).attr('registro');
      znFormulario('registro/visualizar/'+ registro);
  });

  $('body').on('click', '#jqGridRegistro .icon-editar-registro', function () {
      var registro   = $(this).attr('registro');
      znFormulario('registro/actualizar/'+ registro);
  });

  $('body').on('click', '.icon-borrar-registro', function(){
    registro = $(this).attr('registro');
    modales.alert(3, mensaje_response_question.quesBorrar, 'Ok', 'Cancelar', 'agregarClasesEliminar');
 });

  $('body').on('click', '.borrar-registro', function(){
    var direccion_id   = $(this).attr('registro');
    modalAcciones.borrar(direccion_id, 'registro/borrar', 'jqGridRegistro');
  });


  $('body').on('click', '.btn-export-direcciones-xlsx', function(event){
    event.preventDefault()

    $('#buscar_domicilio').val($('#gs_descripcion').val());

    $('#exportarDireccionesXlsx-form').submit();
  });

  $('#form-mantencion').submit(function(event) {
    if ( validarFormularioRegistro ('form-mantencion') ) {
      $(this).unbind('submit').submit();
    } else {
      event.preventDefault();
    }
  });

$('body').on('click', '.btn-toggle-inputEstados', function(){
  checkToggleDireccion ()
});

});
