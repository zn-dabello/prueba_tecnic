@section('title', $title_section)
@extends('layouts.app')
@section('content')
@php 
    $mostrar_input = ['registrar', 'actualizar'];
    $mostrar_estado = ['visualizar', 'actualizar'];
    $mostrar_form = in_array($tipo, $mostrar_input) ? true : false;
    $array_estados = ['0' => 'primary', '1' => 'success', '2' => 'light']; 
@endphp

    <script type="text/javascript">
        var tipo_accion = '{{ $tipo }}';
        let lista_subdirecciones = @json($info_registro['array_subdirecciones']) ?? [];
        let lista_unidades = @json($info_registro['array_unidades']) ?? [];
    </script>

    <div id="accordion-open" data-accordion="open" class="mt-2">
        <x-generales.zn-dsc-modulo value="{{ $etiqueta_accion ?? 'Información del'}} Usuario" />
        <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center hover:bg-gray-200 font-semibold text-lg justify-between w-full px-5 py-2 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span>Ficha</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900 bg-white">
                @include('mi-institucion.usuarios.form')
            </div>
        </div>
        <h2 id="accordion-collapse-heading-2">
            <button type="button" class="flex items-center {{ $tipo != 'registrar' ? 'hover:bg-gray-200' : 'cursor-not-allowed'}} font-semibold text-lg justify-between w-full px-5 py-2 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" {{ $tipo != 'registrar' ? 'data-accordion-target=#accordion-collapse-body-2 aria-expanded=true aria-controls=accordion-collapse-body-2' : ''}}>
            <span>Accesos y Roles</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700  bg-white">
                @if( $tipo != 'registrar' )
                    @include('mi-institucion.usuarios.form-roles')
                @endif
            </div>
        </div>

    </div>

    <script src="{{ versionedAsset('js/App/MiInstitucion/usuarios.js') }}"></script>
    <script>
        mostrarSelectAnidado('{{ old('selectDireccion', $info_registro['direccion_id']) }}', '{{ old('selectSubDireccion', $info_registro['subdireccion_id']) ?? '' }}', lista_subdirecciones, 'selectSubDireccion');
        
        mostrarSelectAnidado('{{ old('selectSubDireccion', $info_registro['subdireccion_id']) }}', '{{ old('selectUnidad', $info_registro['unidad_id']) ?? '' }}', lista_unidades, 'selectUnidad');
        
        procesoEncargadoDe( $("#selectEncargado").val() );
    </script>
@endsection