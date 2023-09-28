@section('title', $title_section)
@extends('layouts.app')
@section('content')
    <script>
        var tipo_estados = @json($tipo_estados);
    </script>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="lg:flex">
            <div class="flex flex-row mt-2 mx-4 overflow-x-auto py-3 md:py-0 md:basis-1/2 md: justify-start">
                <div class="md:basis-autooverflow-x-auto">
                    <x-generales.zn-btn-nuevo :value="__('Agregar Equipo')"  acciones="{{ asset('mantencion/registrar') }}" />
                </div>
                <div class="md:basis-autooverflow-x-auto ms-2">
                    <x-generales.zn-btn-excel :value="__('Descargar excel')" color="bg-green-500" class="btn-export-direcciones-xlsx" />
                </div>
            </div>
            @include('generales.barra-historial')
        </div>

        <div class="p-4 text-gray-900">
            <table id="jqGridRegistro"></table>
            <div id="jqGridPagerRegistrarse"></div>
        </div>

        <form id="exportarDireccionesXlsx-form" action="{{ route('mi-institucion/exportar-excel-direcciones') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="buscar_domicilio" id="buscar_domicilio" value="">
        </form>
    </div>
    <script src="{{ versionedAsset('js/App/Mantenciones/registrar.js') }}"></script>
    <script>
        $(document).ready(function(){
            cargarGrilla ();
        });
    </script>
@endsection
