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

    <div id="accordion-open" data-accordion="open" class="mt-2">
        <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center hover:bg-gray-200 font-semibold text-lg justify-between w-full px-5 py-2 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span>Mis Datos</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900 bg-white">
                <form method="{{$metodo}}" action="{{ route($ruta) }}"  class="w-full" id="form-usuario" accept-charset="UTF-8" enctype="multipart/form-data" >
                    @csrf
                    @if ($tipo == 'actualizar')
                        @method('PATCH')
                        <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
                    @endif
                    <div class="space-y-8 w-full xl:w-3/5">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-2">
                    <!-- Correo -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputCorreo" :value="__('Correo Electrónico')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['correo'] }}" class="w-100" />
                            </div>
                            <!-- Usuario -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputUsuario" :value="__('Usuario')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['usuario'] }}" class="w-100" />
                            </div>
                            <!-- Nombre -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputNombre" :value="__('Nombre')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['nombre'] }}" class="w-100" />
                            </div>
                            <!-- Apellido -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputApellido" :value="__('Apellido')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['apellido'] }}" class="w-100" />
                            </div>
                            <!-- Encargado de -->
                            <div class="my-1">
                                <x-generales.zn-label for="selectEncargado" :value="__('Encargado de')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['encargado'] }}" class="w-100" />
                            </div>
                            <!-- Direccion -->
                            <div class="my-1">
                                <x-generales.zn-label for="selectDireccion" :value="__('Dirección')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['encargado'] }}" class="w-100" />
                            </div>
                            <!-- SubDireccion -->
                            <div class="my-1">
                                <x-generales.zn-label for="selectSubDireccion" :value="__('Sub-Dirección')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['encargado'] }}" class="w-100" />
                            </div>
                            <!-- Unidad -->
                            <div class="my-1">
                                <x-generales.zn-label for="selectUnidad" :value="__('Unidad')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['encargado'] }}" class="w-100" />
                            </div>
                            <!-- Rut -->
                            <div class="my-1">
                                <x-generales.zn-label for="rutUsuario" :value="__('Rut')" class=" mr-0"  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['apellido'] }}" class="w-100" />
                            </div>
                            <!-- Telefono -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputTelefono" :value="__('Teléfono')" class="" />
                                <x-generales.zn-mostrar-datos value="{{ ! empty($info_registro['telefono']) ? '(+56)' . $info_registro['digito']. ' ' . $info_registro['telefono'] : '' }} " class="w-100" />
                            </div>
                            <!-- Cargo -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputCargo" :value="__('Cargo')" class=""  />
                                <x-generales.zn-mostrar-datos value="{{ $info_registro['cargo'] }}" class="w-100" />
                            </div>
                            <!-- Cargo -->
                            <div class="my-1">
                            </div>
                        </div>
                    
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ versionedAsset('js/App/MiInstitucion/usuarios.js') }}"></script>
@endsection