realoadJQgrid_direcciones = false;

function cargarGrilla () {
	/**
   * Accion que permite cargar la lista de direcciones
   * @date    10-08-2023
   * @copyright ZonaNube (zonanube.cl)
   * @author RP
   */
    // Cabecera de la tabla
    var colNames_usuarios = ['', '', '', '<span class="md:visible invisible">Estado</span>', '', '', 'Dirección', 'Descripción'];
    // Indicadores de cada item de la tabla
    var colModel_usuarios = [
        { name: 'borrar', width:40, align:'center', sortable:false, search:false },
        { name: 'editar', width:40, align:'center', sortable:false, search:false },
        { name: 'ver', width:40, align:'center', sortable:false, search:false },
        { name: 'estado', width:140, sortable:false, search:false },
        { name: 'estado_min', hidden:true },
        { name: 'estado_pnt', width:34, align:'center', sortable:false, search:false },
        { name: 'dsc_direccion', width:250 },
        { name: 'descripcion', width:850 }
      ];
    var load_table = znLoadJQgrid(1080, realoadJQgrid_direcciones, 'jqGridSubDirecciones', 'jqGridPagerSubDirecciones', 'ajax-request-sub-direcciones', colNames_usuarios, colModel_usuarios);
    if (load_table){
      realoadJQgrid_direcciones = true;
    }
    //perfiles visualizadores
    $("#jqGridSubDirecciones").bind("jqGridAfterGridComplete", function () {

    });
}


function validarFormularioDireccion (formulario) {

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

let subdireccion;
function agregarClasesEliminar () {
  $('#btn-modal-success').removeAttr('data-modal-hide');
  $('#btn-modal-success').addClass('borrar-subdireccion');
  $('#btn-modal-success').attr('subdireccion', subdireccion);
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

  $('body').on('click', '#jqGridSubDirecciones .icon-ver-subdireccion', function () {
      var subdireccion   = $(this).attr('subdireccion');
      znFormulario('sub-direcciones/visualizar/'+ subdireccion);
  });

  $('body').on('click', '#jqGridSubDirecciones .icon-editar-subdireccion', function () {
      var subdireccion   = $(this).attr('subdireccion');
      znFormulario('sub-direcciones/actualizar/'+ subdireccion);
  });

  $('body').on('click', '.icon-borrar-subdireccion', function(){
    subdireccion = $(this).attr('subdireccion');
    modales.alert(3, mensaje_response_question.quesBorrar, 'Ok', 'Cancelar', 'agregarClasesEliminar');
 });

  $('body').on('click', '.borrar-subdireccion', function(){
    var subdireccion   = $(this).attr('subdireccion');
    modalAcciones.borrar(subdireccion, 'sub-direccion/borrar', 'jqGridSubDirecciones');
  });


  $('body').on('click', '.btn-export-direcciones-xlsx', function(event){
    event.preventDefault()

    $('#buscar_nombre').val($('#gs_nombre').val());
    $('#buscar_telefono').val($('#gs_telefono').val());
    $('#buscar_domicilio').val($('#gs_direccion').val());

    $('#exportarDireccionesXlsx-form').submit();
  });

  $('#form-sub-direccion').submit(function(event) {
    if ( validarFormularioDireccion ('form-sub-direccion') ) {
      $(this).unbind('submit').submit();
    } else {
      event.preventDefault();
    }
  });

$('body').on('click', '.btn-toggle-inputEstados', function(){
  checkToggleDireccion ()
});

});
