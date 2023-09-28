<script type="text/javascript">
   var  info_historial_detalle = @json($info_historial_detalle['cambios']);
  </script>

<div class="contendor_tabla_historial">
	<div class="row justify-content-center align-items-center py-3">
		<table id="jqGridHistorialAccionDetalleListado"></table>
		<div id="jqGridPagerHistorialAccionDetalle"></div>
	</div>
</div>

@if( ! empty($info_historial_detalle['listado']) )

	@foreach ($info_historial_detalle['listado'] as $listado)
		<?php $descripcion_tabla = str_replace(' ', '', $listado['descripcion']); ?>

		@if(!empty($listado['historial']))

		    <div class="my-3">
		    	
		    	<label class="titulo_listado col-form-label ml-3"><b>{{ existe($listado['descripcion']) }}</b></label>

			    <div class="contendor_tabla_historial_{{ $descripcion_tabla }}">
					<div class="row justify-content-center align-items-center mb-3 test-contenedor">
						<table id="jqGridHistorialAccionDetalleListado-{{ $descripcion_tabla }}"></table>
						<div id="jqGridPagerHistorialAccionDetalle-{{ $descripcion_tabla }}"></div>
					</div>
				</div>


				<script type="text/javascript">

				 var iteral_table_historial_detalle = 0;
				 var item_tabla = '{{ $descripcion_tabla }}';
				 var item_historiales = @json($listado['historial']);

				  var colNames = ['', 'Fecha','Acción', 'Registro'];
				  // Indicadores de cada item de la tabla
				  var colModel = [
				    { name: 'detalle', width:40, align:'center' },
				    { name: 'fecha', width:270 },
				    { name: 'accion', width:325 },
				    { name: 'registro', width:325 },
				  ];

				  znLoadJQgridLocal(1020, 'jqGridHistorialAccionDetalleListado-'+item_tabla, 'jqGridPagerHistorialAccionDetalle-'+item_tabla, colNames, colModel, 'not-btn');


				   $.each( item_historiales, function( key, value ) {

				      $("#jqGridHistorialAccionDetalleListado-"+item_tabla).jqGrid(
				          'addRowData', 
				          iteral_table_historial_detalle, {
				          id: iteral_table_historial_detalle,
				          detalle: value.detalle,
				          fecha: formato(value.fecha),
				          accion: value.accion_nombre,
				          registro: value.registro,
				        }, "last",
				      );

				      $('[data-toggle="tooltip"]').tooltip();
				      $('#gbox_jqGridHistorialAccionDetalleListado .ui-jqgrid-bdiv').css('height','150px');

				      iteral_table_historial_detalle ++;

				    });

				</script>

		    </div>

		@endif

	@endforeach

@endif


<script type="text/javascript">
	 var iteral_table_historial_detalle = 0;
	 var realoadJQgrid_historial = false;

	$(document).ready(function(){

	  var colNames = ['Campo','Nuevo', 'Anterior'];
	  // Indicadores de cada item de la tabla
	  var colModel = [
	    { name: 'campo',      width:300, align: 'left' },
	    { name: 'nuevo',      width:325, align: 'left' },
	    { name: 'anterior',   width:325, align: 'left' },
	  ];

	  var load_table = znLoadJQgridData(1020, realoadJQgrid_historial, 'jqGridHistorialAccionDetalleListado', 'jqGridPagerHistorialAccionDetalle',  colNames, colModel, 'not-btna');
	    if (load_table){
	      realoadJQgrid_historial = true;
	    }


	   $.each( info_historial_detalle, function( key, value ) {

      $("#jqGridHistorialAccionDetalleListado").jqGrid(
          'addRowData', 
          iteral_table_historial_detalle, {
          id: iteral_table_historial_detalle,
          campo: value.label,
          nuevo: value.nuevo,
          anterior: value.anterior,
        }, "last",
      );

      $('[data-toggle="tooltip"]').tooltip();
      $('#gbox_jqGridHistorialAccionDetalleListado .ui-jqgrid-bdiv').css('height','300px');
      $('#jqGridPagerHistorialAccionDetalle_left').hide();

      iteral_table_historial_detalle ++;

    });

	});
</script>