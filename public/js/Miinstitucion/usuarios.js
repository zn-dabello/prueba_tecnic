realoadJQgrid_direcciones = false;

function cargarGrilla () {
	/**
   * Accion que permite cargar la lista de direcciones
   * @date    22-08-2023
   * @copyright ZonaNube (zonanube.cl)
   * @author RP
   */
    // Cabecera de la tabla
    var colNames_usuarios = ['', '', '', '', '<span class="md:visible invisible">Estado</span>', '', '', 'Perfil', 'Nombre', 'Correo Electrónico'];
    // Indicadores de cada item de la tabla
    var colModel_usuarios = [
        { name: 'borrar', width:40, align:'center', sortable:false, search:false },
        { name: 'editar', width:40, align:'center', sortable:false, search:false },
        { name: 'clave', width:40, align:'center', sortable:false, search:false },
        { name: 'ver', width:40, align:'center', sortable:false, search:false },
        { name: 'estado', width:140, stype: 'select', searchoptions:{ value: tipo_estados }, index: "estado_min" },
        { name: 'estado_min', hidden:true },
        { name: 'estado_pnt', width:34, align:'center', sortable:false, search:false },
        { name: 'perfil', width:250 },
        { name: 'nombre', width:350 },
        { name: 'correo', width:250 },
      ];
    var load_table = znLoadJQgrid(1080, realoadJQgrid_direcciones, 'jqGridUsuarios', 'jqGridPagerUsuarios', 'ajax-request-usuarios', colNames_usuarios, colModel_usuarios);
    if (load_table){
      realoadJQgrid_direcciones = true;
    }
    //perfiles visualizadores
    $("#jqGridUsuarios").bind("jqGridAfterGridComplete", function () {

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


function comprobarRut () {

    if ( $("#rutUsuario").val() != '' && $("#dvUsuario").val() != '' ) {
        validarRutIngresado('Usuario');
    }

}

let usuario;
function agregarClasesEliminar () {
  $('#btn-modal-success').removeAttr('data-modal-hide');
  $('#btn-modal-success').addClass('borrar-usuario');
  $('#btn-modal-success').attr('usuario', usuario);
}


function checkToggleUsuario () {

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

function recorrerAccesos () {

  var array_accesos = [];

	$('.select-accesos-usuarios').each(function(){
		var tipo 	=	$(this).val();
		var valor_ 	=	$(this).find(':selected').data('modulo-acceso');
    var valor = {
      'acceso': valor_,
      "tipo_acceso": tipo
    };
    array_accesos.push(valor);
	});

  return array_accesos;
}

function procesoEncargadoDe ( tipo_encargado ) {

  $(".block-unidades").hide();
  $(".select-unidades").removeClass('requerido-form-usuario');

  if ( tipo_encargado == 3 ) {

    $(".block-direccion").show();
    $(".select-direccion").addClass('requerido-form-usuario');

  } else if( tipo_encargado == 4 ){

    $(".block-subdireccion").show();
    $(".select-subdireccion").addClass('requerido-form-usuario');
    if(tipo_accion == 'actualizar'){
      mostrarSelectAnidado($("#selectDireccion"), '', lista_subdirecciones, 'selectSubDireccion');
    }

  } else if( tipo_encargado == 5 ){

    $(".block-unidades").show();
    $(".select-unidades").addClass('requerido-form-usuario');
    if(tipo_accion == 'actualizar'){
      mostrarSelectAnidado($("#selectSubDireccion"), '', lista_unidades, 'selectUnidad');
    }

  }

}

$(document).ready(function(){

  $('body').on('click', '#jqGridUsuarios .icon-ver-usuario', function () {
      var usuario = $(this).attr('usuario');
      znFormulario('usuario/visualizar/'+ usuario);
  });

  $('body').on('click', '#jqGridUsuarios .icon-editar-usuario', function () {
      var usuario = $(this).attr('usuario');
      znFormulario('usuario/actualizar/'+ usuario);
  });

  $('body').on('click', '#jqGridUsuarios .icon-clave-usuario', function () {
      var usuario = $(this).attr('usuario');
      znFormulario('usuario/clave/'+ usuario);
  });
  
  $('body').on('click', '.icon-borrar-usuario', function(){
    usuario = $(this).attr('usuario');
    modales.alert(3, mensaje_response_question.quesBorrar, 'Ok', 'Cancelar', 'agregarClasesEliminar');
 });

  $('body').on('click', '.borrar-usuario', function(){
    var usuario_id   = $(this).attr('usuario');
    modalAcciones.borrar(usuario_id, 'usuario/borrar', 'jqGridUsuarios');
  });


  $('body').on('click', '.btn-export-usuarios-xlsx', function(event){
    event.preventDefault()

    $('#buscar_nombre').val($('#gs_nombre').val());
    $('#buscar_telefono').val($('#gs_telefono').val());
    $('#buscar_domicilio').val($('#gs_direccion').val());

    $('#exportarUsuariossXlsx-form').submit();
  });


  $('body').on('change', '#selectEncargado', function(event){

    let encargado = $(this).val();
    procesoEncargadoDe ( encargado );

  });

    $('#form-usuario').submit(function(event) {
        if ( validarFormularioDireccion ('form-usuario') ) {
            $(this).unbind('submit').submit();
        } else {
            event.preventDefault();
        }
    });

    $('body').on('click', '.btn-toggle-inputEstados', function(){
        checkToggleUsuario ()
    });


    $('body').on('change', '#selectDireccion', function(){
      let registro_asociado = $(this).val();
      mostrarSelectAnidado(registro_asociado, '', lista_subdirecciones, 'selectSubDireccion');
    });

    $('body').on('change', '#selectSubDireccion', function(){
      let registro_asociado = $(this).val();
      mostrarSelectAnidado(registro_asociado, '', lista_unidades, 'selectUnidad');
    });

    //////// ACCESOS /////

    $('body').on('click', '.btn-guardar-accesos', function(){
      gestionar_nube();
      $("#inputDatosAcccesos").val(JSON.stringify(recorrerAccesos ()));
      modalAcciones.registrar('form-usuario-accesos', 'actualizar', 'mi-institucion/usuario/editar-accesos')
    });
});
