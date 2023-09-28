$(document).ready(function(){
	gestionar_nube(false);
	
	/**
	 * Accion que permite mostrar y/o ocultar el texto de los campos password
	 *
	 * @date Dic 2019
	 * @copyright ZonaNube (zonanube.cl)
	 * @author SS
	 */
	$("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
	$('body').on('click', '.icon-descripcion', function(){
	    var contenido_descripcion = '<textarea class="text-justify px-2 bg-color-white w-full border-none h-full resize rounded-md" readonly rows="8">' + $(this).attr('contenido') + '</textarea>';
		modales.alert(4, contenido_descripcion, 'Cerrar', null);
	});
	
	$('body').on('input', '.form-control', function(){
	    if ( $(this).val() != '') {
			$(this).removeClass('!border !border-red-500')
		}
	});
	
	$('body').on('change', '.form-control', function(){
	    if ( $(this).val() != '') {
			$(this).removeClass('!border !border-red-500')
		}
	});
});
/**
 * Funcion que permite cargar la informacion de un modulo determinado en una tabla jqgrid
 * @return {[type]} [true / false]
 * @date    01-12-2019
 * @copyright ZonaNube (zonanube.cl)
 * @author SS
 */
function znLoadJQgrid(width_table, realoadJQgridTable, IdJQGrid, IdJQGridPager, url, colNames, colModel, btnTable = 'btn-nuevo-registro', datos_consulta, height_table, showPager = false, rowNumJQ = '60', rowNumPG = '10')
{
	//$('.jqgrow').remove();
	gestionar_nube();

    height_grid = height_table;

    if (height_table == undefined || height_table == '') {
        height_grid = 250;
    }

    $("#"+IdJQGrid).jqGrid("clearGridData");
    visualizadorOpciones (btnTable, IdJQGrid, width_table);
    //$('.'+btnTable).removeClass('ocultar');

	if (realoadJQgridTable) {

      var tabla = $("#"+IdJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
      $(".ui-search-toolbar").hide();
      tabla[0].clearToolbar();
      //$('.ui-jqgrid-btable').css('width', width_table_jqgrid+'px');
      //$('.ui-jqgrid-htable').css('width', width_table_jqgrid+'px');
      return false;

    }
    else{

      	//var width_table_jqgrid = width_table;// Variable para setear el ancho de la tabla
        //$.jgrid.defaults.width = width_table_jqgrid;

		/** TOKEN @CSRF */
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: datos_consulta
		});
		/**
		* Solicitud Json / Post
		*/

		if ( !showPager ) {

			var tabla = $("#"+IdJQGrid).jqGrid({

				url: url,
				mtype: "POST",
				styleUI : 'Bootstrap',
				datatype: "json",
				colNames: colNames,
				colModel: colModel,
				rownumWidth: rowNumJQ,
				height: height_grid,
	            width: width_table,
				rowNum: 1000,
				viewrecords: true,
				cellEdit: true,
				editable: true,
				scroll: 1, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
				emptyrecords: 'No hay registros',
				pager: "#"+IdJQGridPager,
				loadComplete:function(){

					// $('[data-toggle="tooltip"]').tooltip();
					gestionar_nube(false);
	                visualizadorOpciones (btnTable, IdJQGrid, width_table);
					tamaniosJqGrid(IdJQGrid);

				}

			});

		} else {

			var tabla = $("#"+IdJQGrid).jqGrid({

				url: url,
				mtype: "POST",
				styleUI : 'Bootstrap',
				datatype: "json",
				colNames: colNames,
				colModel: colModel,
				rownumWidth: rowNumJQ,
				width: width_table,
				height: height_grid,
				rowNum: rowNumPG,
				loadonce: true,
				rownumbers: true,
				rowList: [5, 10, 20, 30],
				viewrecords: true,
				scroll: false, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
				emptyrecords: 'No hay registros',
				pager: "#"+IdJQGridPager,
				loadComplete:function(){

					// $('[data-toggle="tooltip"]').tooltip();
					gestionar_nube(false);
	                var totalRecords = $('#'+IdJQGrid).getGridParam('records');

	                if (totalRecords < 6) {
	                	$("#" + IdJQGridPager + "_center").hide();
	                } else {
	                	$("#" + IdJQGridPager + "_center").show();
	                }
					
					tamaniosJqGrid(IdJQGrid);

				}

			});
		}

        opcionTablaJQdrid(tabla,IdJQGrid,IdJQGridPager,width_table)

        return true;
    }
}


/**
 * Funcion que permite cargar la informacion de un modulo determinado en una tabla jqgrid haciendo uso de un arreglo (json)
 * desde el servidor
 * @date  Julio 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author SS
 */
function znLoadJQgridJson(width_table, realoadJQgridTable, IdJQGrid, IdJQGridPager, data, colNames, colModel)
{

    $("#"+IdJQGrid).jqGrid("clearGridData");
    gestionar_nube();

	if ( realoadJQgridTable ){
      var tabla = $("#"+IdJQGrid).jqGrid('setGridParam', {datatype:'json'}).trigger("reloadGrid");
      $(".ui-search-toolbar").hide();
      tabla[0].clearToolbar();
      $('.ui-jqgrid-btable').css('width', width_table_jqgrid+'px');
      $('.ui-jqgrid-htable').css('width', width_table_jqgrid+'px');
    //   $('#ModalCargando').modal('hide');
      return false;
    }
    else{
      	//var width_table_jqgrid = width_table;// Variable para setear el ancho de la tabla
        //$.jgrid.defaults.width = width_table_jqgrid;

		var tabla = $("#"+IdJQGrid).jqGrid({

			styleUI : 'Bootstrap',
			datatype: "local",
			data: data,
			colNames: colNames,
			colModel: colModel,
			rownumWidth: 75,
			width: width_table,
			height: 250,
			rowNum: 20,
			loadonce: false,
			rownumbers: true,
			rowList: [10, 20, 30],
			viewrecords: true,
			scroll: false, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
			emptyrecords: 'No hay registros',
			pager: "#"+IdJQGridPager,
			loadComplete:function(){

				// $('[data-toggle="tooltip"]').tooltip();
				gestionar_nube(false);
				tamaniosJqGrid(IdJQGrid);

			}

		});

        opcionTablaJQdrid(tabla,IdJQGrid,IdJQGridPager,width_table)

         return true;
    }
}
/**
 * Funcion que permite cargar la informacion de un modulo determinado en una tabla jqgrid
 * @return {[type]} [true / false]
 * @date    01-12-2019
 * @copyright ZonaNube (zonanube.cl)
 * @author SS
 */
function znLoadJQgridData(width_table, realoadJQgridTable, IdJQGrid, IdJQGridPager, colNames, colModel, btnTable)
{
	$('.'+btnTable).removeClass('ocultar');
	gestionar_nube();
    //visualizadorOpciones (btnTable, IdJQGrid);

	if ( realoadJQgridTable ){
      var tabla = $("#"+IdJQGrid).jqGrid('setGridParam', {datatype:'local'}).trigger("reloadGrid");
      $(".ui-search-toolbar").hide();
      tabla[0].clearToolbar();
      $('.ui-jqgrid-btable').css('width', width_table_jqgrid+'px');
      $('.ui-jqgrid-htable').css('width', width_table_jqgrid+'px');
      return false;
    }
    else{
		//var width_table_jqgrid = width_table;// Variable para setear el ancho de la tabla
		//$.jgrid.defaults.width = width_table_jqgrid;

		/** TOKEN @CSRF */
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
		/**
		* Solicitud Json / Post
		*/
		var tabla = $("#"+IdJQGrid).jqGrid({
			styleUI : 'Bootstrap',
			datatype: "local",
			colNames: colNames,
			colModel: colModel,
			rownumWidth: 75,
			width: width_table,
			height: 250,
			rowNum: 1000,
			viewrecords: true,
			scroll: 1, // set the scroll property to 1 to enable paging with scrollbar - virtual loading of records
			emptyrecords: 'No hay registros',
			pager: "#"+IdJQGridPager,
			loadComplete:function(){

				// $('[data-toggle="tooltip"]').tooltip();
				gestionar_nube(false);
                //visualizadorOpciones (btnTable, IdJQGrid);
				tamaniosJqGrid(IdJQGrid);

			}
		});

        opcionTablaJQdrid(tabla,IdJQGrid,IdJQGridPager,width_table);

        return true;
    }
}


/**
 * Funcion que permite mostrar las opciones para las tablas (botones de filtros, acciones de los filtros)
 * @date  Julio 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author SS
 */
function opcionTablaJQdrid(tabla,IdJQGrid,IdJQGridPager,width_table_jqgrid)
{
	$("#"+IdJQGrid).jqGrid('navGrid', '#'+IdJQGridPager, {

		del: false,
		add: false,
		edit: false,
		search: false,
		refresh: false

	});

	$("#"+IdJQGrid).jqGrid('filterToolbar', {

		stringResult: true,
		searchOnEnter: false,
		defaultSearch: 'cn'

	});

	$("#"+IdJQGrid).jqGrid('navButtonAdd', "#"+IdJQGridPager, {

		caption: "Filtros",
		title: "Filtros",
		buttonicon: 'ui-icon ui-icon-search',
		onClickButton: function () {
			tabla[0].toggleToolbar()
		}

	});

	$("#"+IdJQGrid).jqGrid('navButtonAdd', "#"+IdJQGridPager, {

		caption: "Limpiar",
		title: "Limpiar Búsquedas",
		buttonicon: 'ui-icon ui-icon-refresh',
		onClickButton: function () {
			tabla[0].clearToolbar()
		}

	});

	$(".ui-search-toolbar").hide();
	// ERROR PARA REPORTAR
	$("#"+IdJQGrid+' .ui-jqgrid-btable').css('width', width_table_jqgrid+'px');
	$("#"+IdJQGrid+' .ui-jqgrid-htable').css('width', width_table_jqgrid+'px');
	// END
	$('.ui-search-clear').remove();
	$('#'+IdJQGridPager+'_left').addClass('p-0');
	$('#'+IdJQGridPager+'_left').addClass('ml-3');
	

	$(window).on("resize", function () {
		tamaniosJqGrid(IdJQGrid);
	});
}

/**
 * Funcion que permite cargar la informacion de un modulo determinado en una tabla jqgrid
 * @return {[type]} [true / false]
 * @date    01-12-2019
 * @copyright ZonaNube (zonanube.cl)
 * @author SS
 */
function znLoadJQgridLocal(width_table, IdJQGrid, IdJQGridPager, colNames, colModel, btnTable)
{
	var tabla = $("#"+IdJQGrid).jqGrid({
		datatype: 'local',
		styleUI : 'Bootstrap',
		width: width_table,
		height: 150,
		colNames: colNames,
		colModel: colModel,
		rownumWidth: 75,
		rownumbers: true,
		viewrecords: true,
		pager: "#"+IdJQGridPager,
		loadComplete:function(){

            // $('[data-toggle="tooltip"]').tooltip();
            //visualizadorOpciones (btnTable, IdJQGrid);
            $('.'+btnTable).removeClass('ocultar');
            $('.ui-search-clear').remove();
            gestionar_nube(false);
        }
	});
}

	//opcionTablaJQdrid(tabla,IdJQGrid,IdJQGridPager,width_table);

function visualizadorOpciones (btnTable = 'btn-nuevo-registro', IdJQGrid, widthTable, visualizar = false) {

    if ( visualizar || visualizador_accesos ) {

        $("#"+IdJQGrid).hideCol("editar");
        $("#"+IdJQGrid).hideCol("borrar");
        $("#"+IdJQGrid).hideCol("edit");
        $("#"+IdJQGrid).hideCol("delete");
        $("#"+IdJQGrid).hideCol("revisar");
        $("#"+IdJQGrid).hideCol("subir");
        $("#"+IdJQGrid).hideCol("bajar");
        $("#"+IdJQGrid).hideCol("clave");
        $('.'+btnTable).addClass('hidden');

    } else {
        $('.'+btnTable).removeClass('hidden');
    }

   //$("#"+IdJQGrid).setGridWidth( widthTable, true );
   // $("#"+IdJQGrid).jqGrid('resizeColumn', 'descripcion', 260 );


}

function tamaniosJqGrid(IdJQGrid) {

    var grilla = $("#"+IdJQGrid);
    var newWidth = grilla.closest("#gbox_"+IdJQGrid).parent().width();
	var newWidthEstado = 140;

    if (newWidth > 0) {
	    if (newWidth < 700) {
	    	ocultarColumnasMobile(IdJQGrid);
			newWidthEstado = 40;
	    } else {
	    	ocultarColumnasMobile(IdJQGrid, false);
	    }
		
		$("#"+IdJQGrid).jqGrid('setColProp', 'estado', { width: newWidthEstado });
    	grilla.jqGrid("setGridWidth", newWidth, false);
	    
    }
    
}

function gestionar_nube ( abrir_nube = true ){

	if ( abrir_nube ) {
		$( "#btn-cargar-nube" ).trigger( "click" );
	} else {
		$( "#btn-cerrar-nube" ).trigger( "click" );
	}
	
}


function znFormulario(ruta)
{
	window.location.href = ruta;
}



function camposObligatorios(id_form)
{
	var campos_obligatorios = 1;
	$('.requerido-'+id_form).each(function(){
		var valor_campo 	=	$(this).val();
		if (valor_campo == '' || valor_campo == null){
			$(this).addClass('!border !border-red-500');
			campos_obligatorios = 0;
		} else {
			$(this).removeClass('!border !border-red-500');
		}
	});
	return campos_obligatorios;
}

function ocultarClases(id_clase)
{console.log(id_clase);
	$('.'+ id_clase).each(function(){
		console.log($(this));
		$(this).hide();
	});
	
}

function mostrarClases(id_clase)
{
	$('.'+ id_clase).each(function(){
		$(this).show();
	});
	
}

function quitarObligatorio(id_clase, obligatorio_clase)
{
	$('.'+ id_clase).each(function(){
		$(this).removeClass(obligatorio_clase);
	});
	
}

function agregarOligatorio(id_clase, obligatorio_clase)
{
	$('.'+ id_clase).each(function(){
		$(this).addClass(obligatorio_clase);
	});
	
}



function ocultarColumnasMobile (IdJQGrid = "", ocultar = true, mostrar_mobile = false) {
	if (ocultar) {

    	$("#"+IdJQGrid).showCol("estado_pnt");
        $("#"+IdJQGrid).hideCol("estado");

	} else {

    	$("#"+IdJQGrid).hideCol("estado_pnt");
        $("#"+IdJQGrid).showCol("estado");
        

	}
}


function compararFecha(fecha, fecha2) {

	var xMonth = fecha.substring(3, 5);
    var xDay = fecha.substring(0, 2);
    var xYear = fecha.substring(6,10);
    var yMonth = fecha2.substring(3, 5);
    var yDay  = fecha2.substring(0, 2);
    var yYear = fecha2.substring(6,10);

    if (xYear> yYear) {
        return(true)
    }
    else {

	    if (xYear == yYear) {

	        if (xMonth> yMonth){
	            return(true);
	        }
	        else {

				if (xMonth == yMonth) {

					if (xDay> yDay) {
						return(true);
					}
					else{
						return(false);
					}
				}
				else{
					return(false);
				}
			}
		}
		else {
			return(false);
		}

    }

}


    /**
   * Funcion que permite validar el rut
   * @date    Dic 2019
   * @copyright ZonaNube (zonanube.cl)
  * @author RP
   */
	function znValidarRut (rut, clase_mensaje = 'rut') {

		var rut_valido = true;
		$("#"+rut).rut()
			.on('rutInvalido', function(){
				if($("#"+rut).val() != ''){
					$("#"+rut).addClass("is-invalid-rut");
					$('.msg-error-'+clase_mensaje).html('Rut Inválido');
					$('.msg-error-'+clase_mensaje).show();
					rut_valido = false;
					console.log('paso invalido');
				}else{
					$("#"+clase_mensaje).removeClass("is-invalid-rut");
					$('.msg-error-'+clase_mensaje).html('');
				    $('.msg-error-'+clase_mensaje).hide();
					rut_valido = true;
					console.log('paso valido');
				}
			})
			.on('rutValido', function(){
				$("#"+clase_mensaje).removeClass("is-invalid-rut");
				$('.msg-error-'+clase_mensaje).html('');
				$('.msg-error-'+clase_mensaje).hide();
				rut_valido = true;
				console.log('paso valido 2');
			});
		console.log('no paso', $("#"+rut).rut());
	
		return rut_valido;
	
	}

	

function validarRutIngresado(sufijo) {
	var continuar = true;
	if ($("#dv"+sufijo).val() != "" && $("#rut"+sufijo).val() != "") {
		var dv = checkDV($("#dv"+sufijo).val(), "msg"+sufijo);
		if (dv) {
			var rut = validarRut($("#rut"+sufijo).val(), $("#dv"+sufijo).val(), "msg"+sufijo);
			if (!rut) {
				continuar = false;
				$("#msg"+sufijo).show();
			}
			else {
				$("#msg"+sufijo).hide();
			}
		}
		else {
			continuar = false;
			$("#msg"+sufijo).show();
		}
	}
	else {
		$("#msg"+sufijo).hide();
	}
	
	return continuar;
}

function checkDV(dv, msgError) {
	if ( dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' 
			&& dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K') {
		$("#"+msgError).html("Debe ingresar un dígito verificador válido.");
		return false;
	}
	
	return true;
}

function validarRut(r, dv, msgError) {
	var rut = r.split('.').join('');
	if ($.trim(rut) == "" || $.trim(dv) == "") {
		$("#"+msgError).html("El rut ingresado no es válido.");
		return false;
	}
	
	var tmp =new Array(0, 0, 0, 0, 0, 0, 0, 0), i = 0;
	for (var c = rut.length - 1; c >= 0; c--)  {
		tmp[i] = rut.charAt(c);
		i++;
	}
	
	var suma = 11 - (((tmp[0] * 2) + (tmp[1] * 3) + (tmp[2] * 4) + (tmp[3] * 5) + (tmp[4] * 6) + (tmp[5] * 7) + (tmp[6] * 2) + (tmp[7] * 3)) % 11);
	var dvtmp = suma;
	if (suma == 10)  dvtmp = "K";
	else if (suma == 11) dvtmp = 0;
	
	if (dv.toUpperCase() != dvtmp) {
		$("#"+msgError).html("El rut ingresado no es válido.");
		return false;
	}
	else return true;
}


/**
 * Convierte un texto de la forma 2017-01-10 a la forma
 * 10/01/2017
 *
 * @param {string} texto Texto de la forma 2017-01-10
 * @return {string} texto de la forma 10/01/2017
 *
 */
function formato(fecha){
	var d = new Date(fecha);
	   return (d.toLocaleString("es-CL"));
}

/**
 * Funcion que pemirte listar los select dependientes de uno superior
 * @param  {[type]} superior_id [Id del Select Superior]
 * @param  {[type]} opcion_por_defecto [ID del Opcion seleccionada]
 * @param  {[type]} lista_opciones [Lista de opciones disponibles]
 * @param  {[type]} id_select_dependiente [ID del select Superior]
 * @param  {[type]} clase_select_dependiente [clase que identifica al select que se va a cargar]
 * @date Julio 2020
 * @copyright Zona Nube
 * @author RP
 */
function mostrarSelectAnidado(superior_id, opcion_por_defecto, lista_opciones, id_select_dependiente)
{
    var lista_dependientes = [];

    $.each(lista_opciones, function( index, value ) {
        var items = [];
        if (value.relacion == superior_id){
            items['id'] = value.id;
            items['descripcion'] = value.descripcion;
            items['relacion'] = value.relacion;

            lista_dependientes.push(items);
        }
    });

    if ( superior_id > 0){
        var dependiente_option =   '<option value="" selected>SELECCIONE</option>';
                                $.each( lista_dependientes, function( key_select, value_dependiente ) {
                                    var selected_registro = ( opcion_por_defecto == value_dependiente.id ? 'selected' : '');
                                    dependiente_option += '<option value="'+value_dependiente.id+'" '+selected_registro+' >'+value_dependiente.descripcion+'</option>';
                                });

        $('#'+id_select_dependiente).find('option').remove();
        $('#'+id_select_dependiente).html(dependiente_option);
        $('select[id='+id_select_dependiente+']').val("");

        if( opcion_por_defecto != "" ){
            $('select[id='+id_select_dependiente+']').val(opcion_por_defecto);
        }
    }

}
