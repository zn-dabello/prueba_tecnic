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
</script>
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex flex-row mt-2 mx-4 py-4">
        <form method="{{$metodo}}" action="{{ route($ruta) }}" class="w-full" id="form-mantencion" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            @if ($tipo == 'actualizar')
                @method('PATCH')
                <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
            @endif
            <div class="space-y-8 grid-cols-1 w-full xl:w-3/5">
                <x-generales.zn-dsc-modulo value="{{ $etiqueta_accion ?? 'Ver Información de la'}} Registro de equipos" />
                <div class="my-1">
                    <x-generales.zn-label for="fecha_mantencion" :value="__('Fecha de Mantención')" class="lg:w-1/3" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}" />
                    @if($mostrar_form)
                        <x-generales.zn-input type="date" name="fecha_mantencion" id="fecha_mantencion" class="py-2 requerido-form-mantencion" value="{{ isset($info_registro['fecha_mantencion']) ? old('fecha_mantencion', $info_registro['fecha_mantencion']) : old('fecha_mantencion') }}" autofocus />
                        <x-generales.input-error :messages="$errors->first('fecha_mantencion')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['fecha_mantencion'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>

                <div class="my-1">
                    <x-generales.zn-label for="numero_equipo" :value="__('Número de Equipo')" class="lg:w-1/3" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}" />
                    @if($mostrar_form)
                        <x-generales.zn-input type="text" name="numero_equipo" id="numero_equipo" class="py-2 requerido-form-mantencion" value="{{ isset($info_registro['numero_equipo']) ? old('numero_equipo', $info_registro['numero_equipo']) : old('numero_equipo') }}" />
                        <x-generales.input-error :messages="$errors->first('numero_equipo')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['numero_equipo'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>

                <div class="my-1">
                    <x-generales.zn-label for="marca_equipo" :value="__('Marca del Equipo')" class="lg:w-1/3" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}" />
                    @if($mostrar_form)
                        <x-generales.zn-input type="text" name="marca_equipo" id="marca_equipo" class="py-2 requerido-form-mantencion" value="{{ isset($info_registro['marca_equipo']) ? old('marca_equipo', $info_registro['marca_equipo']) : old('marca_equipo') }}" />
                        <x-generales.input-error :messages="$errors->first('marca_equipo')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['marca_equipo'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>

                <div class="my-1">
                    <x-generales.zn-label for="ubicacion" :value="__('Ubicación')" class="lg:w-1/3" />
                    @if($mostrar_form)
                        <x-generales.zn-input type="text" name="ubicacion" id="ubicacion" class="py-2" value="{{ isset($info_registro['ubicacion']) ? old('ubicacion', $info_registro['ubicacion']) : old('ubicacion') }}" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['ubicacion'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>

                <div class="my-1">
                    <x-generales.zn-label for="proveedor" :value="__('Proveedor')" class="lg:w-1/3" />
                    @if($mostrar_form)
                        <x-generales.zn-input type="text" name="proveedor" id="proveedor" class="py-2" value="{{ isset($info_registro['proveedor']) ? old('proveedor', $info_registro['proveedor']) : old('proveedor') }}" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['proveedor'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>

                <select name="repuesto_id" id="repuesto_id" class="form-control form-input py-1 px-2 w-20 rounded text-sm requerido-form-mantencion">>
                    <option value="">Selecciona un repuesto</option>
                    @foreach ($repuestos as $repuesto)
                        <option value="{{ $repuesto['id'] }}">{{ $repuesto['nombre_repuesto'] }}</option>
                    @endforeach
                </select>


                @if(in_array($tipo, $mostrar_estado))
                    <div class="my-1">
                        <x-generales.zn-label for="estado" :value="__('Estado')" class="lg:w-1/3" maxlength="150" />
                        @if($mostrar_form)
                            <input name="estado_id" id="estado_id" type="hidden" value="{{ isset($info_registro['estado_id']) ? old('estado_id', $info_registro['estado_id']) : old('estado_id') }}" />
                            <x-generales.zn-toggle name="inputEstados" descripcion="{{ $info_registro['estado'] }}" value="{{ isset($info_registro['estado_id']) ? old('estado_id', $info_registro['estado_id']) : old('estado_id') }}" />
                            <x-generales.input-error :messages="$errors->first('estado_id')" class="mt-2" />
                        @else
                            <div class="w-48">
                                <x-generales.zn-badge-estado texto="{{ $info_registro['estado'] }}" class="{{ $info_registro['css_estado'] }}" />
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Advertencia -->
                @if(in_array($tipo, $mostrar_input))
                    <div class="my-1">
                        <x-generales.zn-advertencia-requerido />
                    </div>
                @endif

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    @if($tipo != 'visualizar')
                        <x-generales.zn-btn-enviar value="Guardar" />
                    @endif
                    <x-generales.zn-btn-cancelar value="{{ $tipo != 'visualizar' ? 'Cancelar' : 'Volver'}}" href="{{ route('mantencion/registrarse')}}" />
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ versionedAsset('js/App/Mantenciones/registrar.js') }}"></script>
@endsection
