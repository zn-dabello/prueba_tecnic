@props(['name', 'value' => '', 'array_months' => "", 'shortMonths' => ""])
<div class="relative w-48 me-4 mb-4">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
        </svg>
    </div>
    <input name="{{$name ?? '' }}" id="{{$name ?? '' }}" data-date="{{ $value }}" datepicker-format="dd-mm-yyyy" value="{{ $value }}" datepicker type="text" datepicker-language="es" datepicker-monthsShort="{{ $shortMonths }}" datepicker-autohide class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Seleccione una fecha">
</div>
<script>

    var meses_data_date = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    var meses_data_date_short = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    var meses_cambiar_datepicker = true;
    
    $("#{{$name}}").attr('datepicker-months', meses_data_date);
    $("#{{$name}}").attr('datepicker-monthsShort', meses_data_date_short);
    $("#{{$name}}").attr('datepicker-changeMonth');
    
</script>
