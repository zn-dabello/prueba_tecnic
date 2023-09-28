
<div class="contenedor-historial p-2">
    <div class="contenedor_filtros">
        
        <br>
        <div class="row form-group">
            <label class="col-md-2 col-form-label">Tipo de búsqueda </label>
            <div class="col-md-2">
                <input class="form-control input-checkbox" id="inputTipoBusqueda" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="primary" data-style="ios" value="">
                <input type="hidden" id="inputHiddenTodosHistorial" value="1">
            </div>

        </div>

        <div class="row form-group align-items-center campos-filtro-fecha ocultar">

            <label class="col-md-2 col-form-label">Rango </label>
            <label class="col-md-1 col-form-label float-right">Desde:</label>
            <div class="col-md-2 input-group date p-0">

                <input type="text" width="100" data-provide="datepicker" readonly id="fechaDesde" class="form-control campo_fecha zn-clickable" autocomplete="off" >
                <div class="input-group-text-right">
                    <i class="zn-sprite calendario zn-clickable" id="iconoFechaDesde"></i>
                </div>

            </div>

            <label class="col-md-1 col-form-label float-right">Hasta:</label>
            <div class="col-md-2 input-group date p-0">

                <input type="text" width="100" data-provide="datepicker" readonly id="fechaHasta" class="form-control campo_fecha zn-clickable" autocomplete="off" >
                <div class="input-group-text-right">
                    <i class="zn-sprite calendario zn-clickable" id="iconoFechaHasta"></i>
                </div>

            </div>

        </div>

        <div class="row justify-content-center align-items-center">

            <div class="col-md-2 offset-md-2 px-0">
                <button type="button" class="btn btn-success btn-buscar-historial text-center float-right"><span class="zn-sprite ver"> </span> Buscar</button>
            </div>
            
        </div>

        <div class="row">

            <div class="col-md-12">
                <span class="invalid-feedback msn-input-alert-form-historial" role="alert"></span>
            </div>

        </div>

    </div>

    <div class="resultado-historial">
        <div class="contendor_tabla_historial">
            <hr class="mt-3">
           
            <div class="row justify-content-center align-items-center mb-3">
                <table id="jqGridHistorialAccion"></table>
                <div id="jqGridPagerHistorialAccion"></div>
            </div>

        </div>
    </div>

</div>


<script type="text/javascript">
    
    var acciones_historiales = @json($acciones_historial);

    $('#inputTipoBusqueda').bootstrapToggle({
        on: '{{ textoMayuscula(session('plataforma.user.cliente.id'), "Buscar por Fecha") }} ',
        off: '{{ textoMayuscula(session('plataforma.user.cliente.id'), "Buscar todo") }}',
        width: 175,
        height: 2
    });

    $('.campo_fecha').datepicker();
    // set default dates
    var start = new Date();
    // set end date to max one year period:
    var end = new Date(new Date().setYear(start.getFullYear()+1));

    $('#fechaDesde').datepicker({
        startDate : start,
        autoClose : true,
        endDate   : end
    // update "fechaHasta" defaults whenever "fechaDesde" changes
    }).on('changeDate', function(){
        $('#fechaHasta').datepicker('setStartDate', new Date(formatoDateFirefox($('#fechaDesde').val())));
        $('.msn-input-alert-form-historial').html('');
        $(".campo_fecha" ).removeClass('is-invalid');
    }); 

    $('#fechaDesde').on('changeDate', function(ev){
        $(this).datepicker('hide');
        $(this).removeClass('is-invalid');
    });

    $('#fechaHasta').datepicker({
        startDate : start,
        autoClose : true,
        endDate   : end
    // update "fechaDesde" defaults whenever "fechaHasta" changes
    }).on('changeDate', function(){
        $('#fechaDesde').datepicker('setEndDate', new Date(formatoDateFirefox($('#fechaHasta').val())));
        $('.msn-input-alert-form-historial').html('');
        $(".campo_fecha" ).removeClass('is-invalid');
    });

    $('#fechaHasta').on('changeDate', function(ev){
        $(this).datepicker('hide');
        $(this).removeClass('is-invalid');
    });

  $(document).ready(function(){

    $('#iconoFechaHasta').click(function() {
        $("#fechaHasta").focus();
    });

    $('#iconoFechaDesde').click(function() {
        $("#fechaDesde").focus();
    });


    var tamanio_realizado = (tipo_modulo == 46 || tipo_modulo == 47) ? 640 : 280;

    var colNames = ['','Fecha', 'Acción', 'Tipo de Registro', '', 'Registro', 'Realizado Por'];
    // Indicadores de cada item de la tabla
    var colModel = [
      { name: 'detalle_historial', width:30, sortable:false, search:false },
      { name: 'fecha', width:180, sorttype: "date",    formatter: "date",    formatoptions: { srcformat: "d-m-Y H:i:s", newformat: "d-m-Y H:i:s" } },
      { name: 'accion_nombre', width:130, align: 'center', stype: 'select', searchoptions:{ value: acciones_historiales }   },
      { name: 'tipo_registro', width:250, stype: 'select', searchoptions:{ value: tipo_registros_historial } },
      { name: 'registro_index', width:380, hidden:true },
      { name: 'registro', width:380, index: 'registro_index' },
      { name: 'realizado', width:tamanio_realizado },
    ];

    var realoadJQgrid_historial = false;

    var load_table = znLoadJQgridData(1050, realoadJQgrid_historial, 'jqGridHistorialAccion', 'jqGridPagerHistorialAccion',  colNames, colModel, 'not-btna');

    if (load_table) {
      realoadJQgrid_historial = true;
    } 

    if (tipo_modulo == 46 || tipo_modulo == 47) {
      $("#jqGridHistorialAccion").hideCol("tipo_registro");
      $("#jqGridHistorialAccion").hideCol("registro");
      $("#jqGridHistorialAccion").hideCol("detalle_historial");
    } 

  });

 
  


</script>