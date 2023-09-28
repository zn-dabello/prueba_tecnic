<!-- Main modal -->
<div id="modalHistorial" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between px-4 py-2 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg pt-1 font-semibold text-gray-900 dark:text-white">
                    Historial de Acciones
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalHistorial">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 max-w-3xl">
                <div class="flex">
                    <x-generales.zn-label  :value="__('Tipo de búsqueda')" class="lg:w-1/3" maxlength="150" />
                    <x-generales.zn-toggle name="inputHiddenTodosHistorial" />
                </div>
                <div id="buscadorHistorialFecha" class="flex">
                    <x-generales.zn-label  :value="__('Rango')" class="lg:w-1/3" maxlength="150" />
                    <x-generales.zn-input-date class="me-5" name="fechaDesde" />
                    <x-generales.zn-input-date name="fechaHasta" />
                </div>
                <div class="flex flex-row  justify-end">
                    <button type="button" class="btn-buscar-historial justify-self-end zn-boton-success-modal text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex px-5 py-2.5 text-center mr-2">Buscar</button>
                </div>
            </div>
            <!-- Resultado -->
            <div class="resultado-historial w-full px-6 space-y-6 max-w-6x">
                <div class="contendor_tabla_historial">
                    <hr class="mb-3">
                    <div class="row justify-content-center align-items-center mb-3">
                        <table id="jqGridHistorialAccion"></table>
                        <div id="jqGridPagerHistorialAccion"></div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                <button data-modal-hide="modalHistorial" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>

    var acciones_historiales = @json($historial_acciones);

    $(document).ready(function(){
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