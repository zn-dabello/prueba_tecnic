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
        <div class="flex flex-row mt-2 mx-4 py-4 ">
            <form method="{{$metodo}}" action="{{ route($ruta) }}"  class="w-full" id="form-sub-direccion" accept-charset="UTF-8" enctype="multipart/form-data" >
                @csrf
                @if ($tipo == 'actualizar')
                    @method('PATCH')
                    <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
                @endif
                <div class="space-y-8 grid-cols-1 w-full xl:w-3/5">
                    <h3 class="text-2xl font-semibold leading-10 text-blue-400 border-b-4 border-gray-300">{{ $etiqueta_accion ?? 'Información de'}} Sub-Direcciones</h3>

                    <div class="my-1">
                        <x-generales.zn-label for="selectSubDireccion" :value="__('Dirección')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                        @if($mostrar_form)
                            <select name="selectSubDireccion" id="selectSubDireccion" class="form-control form-input py-1 px-2 w-20 rounded text-sm requerido-form-sub-direccion">
                                <option value="">SELECCIONE</option>
                                @foreach ($subDirecciones as $subDireccion)
                                    <option value="{{ $subDireccion['id'] }}">{{ $subDireccion['descripcion'] }}</option>
                                @endforeach
                            </select>

                            <x-generales.input-error :messages="$errors->first('selectSubDireccion')" class="mt-2" />
                        @else
                            <x-generales.zn-mostrar-datos value="{{ $info_registro['descripcion'] }}" class="w-100" />
                        @endif
                    </div>

                    <div class="my-1">
                        <x-generales.zn-label for="inputDescripcion" :value="__('Descripción')" class="lg:w-1/3" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                        @if($mostrar_form)
                            <x-generales.zn-textarea name="inputDescripcion" id="inputDescripcion" class="py-2 " value="{{ isset($info_registro['descripcion']) ? old('inputDescripcion', $info_registro['descripcion']) : old('inputDescripcion')  }}" autofocus required maxlength="500" rows=5 />
                            <x-generales.input-error :messages="$errors->first('inputDescripcion')" class="mt-2" />
                        @else
                            <x-generales.zn-mostrar-datos value="{{ $info_registro['descripcion'] }}" class="w-100 lg:w-2/3" />
                        @endif
                    </div>

                    @if(in_array($tipo, $mostrar_estado))
                        <div class="my-1 lg:flex">
                            <x-generales.zn-label for="inputEstado" :value="__('Estado')" class="lg:w-1/3" requerido="{{ in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  maxlength="150" />
                            @if($mostrar_form)
                                <input name="inputEstado" id="inputEstado" type="hidden" value="{{ isset($info_registro['estado_id']) ? old('inputEstado', $info_registro['estado_id']) : old('inputEstado') }}" />
                                <x-generales.zn-toggle name="inputEstados" descripcion="{{ $info_registro['estado'] }}" value="{{ isset($info_registro['estado_id']) ? old('inputEstado', $info_registro['estado_id']) : old('inputEstado') }}" />
                                <x-generales.input-error :messages="$errors->first('inputEstado')" class="mt-2" />
                            @else
                                <x-generales.zn-badge-estado texto="{{ $info_registro['estado'] }}" class="{{ $info_registro['css_estado'] }}" />
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        @if($tipo != 'visualizar')
                            <x-generales.zn-btn-enviar value="Guardar" />
                        @endif
                        <x-generales.zn-btn-cancelar value="Cancelar" href="{{ route('mi-institucion/sub-direcciones')}}" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ versionedAsset('js/App/MiInstitucion/subdirecciones.js') }}"></script>
@endsection
