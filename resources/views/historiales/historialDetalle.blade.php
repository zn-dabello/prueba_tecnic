<div class="relative w-full h-full">
	<!-- Modal content -->
	<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
		<!-- Modal header -->
		<div class="flex items-start justify-between px-4 py-2 border-b rounded-t dark:border-gray-600">
			<h3 class="text-lg pt-1 font-semibold text-gray-900 dark:text-white">
				Detalle Historial
			</h3>
		</div>
		<script type="text/javascript">
		var  info_historial_detalle = @json($info_historial_detalle['cambios']);
		</script>

		<div class="contendor_tabla_historial w-full px-6 space-y-6 max-w-6x">
			<div class="row justify-content-center align-items-center py-3 block-detalle-acciones">
				<table id="jqGridHistorialAccionDetalle"></table>
				<div id="jqGridPagerHistorialAccionDetalle"></div>
			</div>
		</div>
		@if( ! empty($info_historial_detalle['listado']) )

			@foreach ($info_historial_detalle['listado'] as $listado)
				<?php $descripcion_tabla = 'detalle_tabla'; ?>

				@if(!empty($listado['historial']))

					<div class="my-3">
						
						<label class="titulo_listado col-form-label ml-3"><b>{{ existe($listado['descripcion']) }}</b></label>

						<div class="contendor_tabla_historial_{{ $descripcion_tabla }}">
							<div class="row justify-content-center align-items-center mb-3 test-contenedor">
								<table id="jqGridHistorialAccionDetalle-{{ $descripcion_tabla }}"></table>
								<div id="jqGridPagerHistorialAccionDetalle-{{ $descripcion_tabla }}"></div>
							</div>
						</div>


						<script type="text/javascript">

						var iteral_table_historial_detalle = 0;
						var item_tabla = '{{ $descripcion_tabla }}';
						var item_historiales = @json($listado['historial']);

						var colNames = ['', 'Fecha','Tipo de Registro','Acción', 'Registro'];
						// Indicadores de cada item de la tabla
						var colModel = [
							{ name: 'detalle', width:40, align:'center' },
							{ name: 'fecha', width:200, sorttype: "date",    formatter: "date",    formatoptions: { srcformat: "d-m-Y, H:i:s", newformat: "d-m-Y H:i:s" } },
							{ name: 'descripcion', width:250 },
							{ name: 'accion', width:150 },
							{ name: 'registro', width:300 },
						];

						znLoadJQgridLocal(1020, 'jqGridHistorialAccionDetalle-'+item_tabla, 'jqGridPagerHistorialAccionDetalle-'+item_tabla, colNames, colModel, 'not-btn');


						$.each( item_historiales, function( key, value ) {

							$("#jqGridHistorialAccionDetalle-"+item_tabla).jqGrid(
								'addRowData', 
								iteral_table_historial_detalle, {
								id: iteral_table_historial_detalle,
								detalle: value.detalle,
								fecha: formato(value.fecha),
								descripcion: value.descripcion,
								accion: value.accion_nombre,
								registro: value.registro,
								}, "last",
							);

							$('[data-toggle="tooltip"]').tooltip();
							$('#gbox_jqGridHistorialAccionDetalle .ui-jqgrid-bdiv').css('height','150px');

							iteral_table_historial_detalle ++;

							});

						</script>

					</div>

				@endif

			@endforeach

		@endif
		<!-- Modal footer -->
		<div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
			<button type="button" class="btn-volver-historial-buscar text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Volver</button>
		</div>
	</div>
</div>


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

	  var load_table = znLoadJQgridData(1020, realoadJQgrid_historial, 'jqGridHistorialAccionDetalle', 'jqGridPagerHistorialAccionDetalle',  colNames, colModel, 'not-btna');
	    if (load_table){
	      realoadJQgrid_historial = true;
	    }


	   $.each( info_historial_detalle, function( key, value ) {

      $("#jqGridHistorialAccionDetalle").jqGrid(
          'addRowData', 
          iteral_table_historial_detalle, {
          id: iteral_table_historial_detalle,
          campo: value.label,
          nuevo: value.nuevo,
          anterior: value.anterior,
        }, "last",
      );

    //   $('[data-toggle="tooltip"]').tooltip();
      $('#gbox_jqGridHistorialAccionDetalle .ui-jqgrid-bdiv').css('height','300px');
      $('#jqGridPagerHistorialAccionDetalle_left').hide();

      iteral_table_historial_detalle ++;

    });

		var total_filas = $("#jqGridHistorialAccionDetalle").jqGrid('getGridParam', 'records');
		if (total_filas == 0) {
			$(".block-detalle-acciones").addClass('ocultar');
		} else {
			$(".block-detalle-acciones").removeClass('ocultar');
		}

	});
</script>