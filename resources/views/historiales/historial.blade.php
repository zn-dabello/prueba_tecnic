<script type="text/javascript">
  var lista_historial = @json($info_historial);
  var eliminar_columna_tipo_registro = @json($eliminar_columna_tipo_registro);
</script>

<div class="contendor_tabla_historial">
  <hr class="mt-3">
  <div class="row justify-content-center align-items-center mb-3">
    <table id="jqGridHistorialAccion"></table>
    <div id="jqGridPagerHistorialAccion"></div>
  </div>
</div>

<script type="text/javascript">
   var iteral_table_historial = 0;
   var realoadJQgrid_historial = false;
   var tamanio_realizado = (tipo_modulo == 46 || tipo_modulo == 47 || tipo_modulo == 45) ? 640 : 280;

  $(document).ready(function(){
    var colNames = ['','Fecha', 'Acción', 'Tipo de Registro', '', 'Registro', 'Tipo Sub-Registro', 'Sub-Registro', '', 'Realizado Por'];
    // Indicadores de cada item de la tabla
    var colModel = [
      { name: 'detalle_historial', align:'center', width:40, sortable:false, search:false },
      { name: 'fecha', width:180, sorttype: "date",    formatter: "date",    formatoptions: { srcformat: "d-m-Y H:i:s", newformat: "d-m-Y H:i:s" } },
      { name: 'accion_nombre', width:190, align: 'center', stype: 'select', searchoptions:{ value: acciones_historiales }   },
      { name: 'tipo_registro', width:250, stype: 'select', searchoptions:{ value: tipo_registros_historial } },
      { name: 'registro_index', width:380, hidden:true },
      { name: 'registro', width:380, index: 'registro_index' },
      { name: 'sub_tipo', width:250 },
      { name: 'sub_registro', width:380, index: 'sub_registro_index' },
      { name: 'sub_registro_index', width:380, hidden: true},
      { name: 'realizado', width:tamanio_realizado },
    ];

    var load_table = znLoadJQgridJson(1050, realoadJQgrid_historial, 'jqGridHistorialAccion', 'jqGridPagerHistorialAccion', lista_historial, colNames, colModel);

    if (load_table){
      realoadJQgrid_historial = true;
    }

    if (eliminar_columna_tipo_registro == 1) {
        $("#jqGridHistorialAccion").hideCol("tipo_registro");
    }

    if (tipo_modulo == 46 || tipo_modulo == 47) {
      $("#jqGridHistorialAccion").hideCol("tipo_registro");
      $("#jqGridHistorialAccion").hideCol("registro");
      $("#jqGridHistorialAccion").hideCol("detalle_historial");
    } else if (tipo_modulo == 48 || tipo_modulo == 45) {
      $("#jqGridHistorialAccion").hideCol("registro");
    }


    if ( typeof tiene_listado === 'undefined' ) {
      $("#jqGridHistorialAccion").hideCol("sub_tipo");
      $("#jqGridHistorialAccion").hideCol("sub_registro");
    }
        
    // $('#contenedor-principal').dialog({
    //     position: { my: "center", at: "top+310", of: window }
    // });

  });

</script>