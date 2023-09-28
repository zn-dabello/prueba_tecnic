<form method="{{$metodo}}" action="{{ route($ruta) }}"  class="w-full" id="form-usuario" accept-charset="UTF-8" enctype="multipart/form-data" >
    @csrf
    @if ($tipo == 'actualizar')
        @method('PATCH')
        <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
    @endif
    <div class="space-y-8 w-full xl:w-3/5">
        <div class="lg:grid lg:grid-cols-2 lg:gap-y-2 lg:gap-x-12">
    <!-- Correo -->
            <div class="my-1">
                <x-generales.zn-label for="inputCorreo" :value="__('Correo Electrónico')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                @if($mostrar_form)
                    <x-generales.zn-input type="email" name="inputCorreo" id="inputCorreo" class="py-2 requerido-form-usuario" value="{{ isset($info_registro['correo']) ? old('inputCorreo', $info_registro['correo']) : old('inputCorreo')  }}" autofocddus maxlength="500" />
                    <x-generales.input-error :messages="$errors->first('inputCorreo')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['correo'] }}" class="w-100" />
                @endif
            </div>
            <!-- Usuario -->
            <div class="my-1">
                <x-generales.zn-label for="inputUsuario" :value="__('Usuario')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                @if($mostrar_form)
                    <x-generales.zn-input name="inputUsuario" id="inputUsuario" class="py-2 requerido-form-usuario" value="{{ isset($info_registro['usuario']) ? old('inputUsuario', $info_registro['usuario']) : old('inputUsuario')  }}" autofocddus maxlength="500" />
                    <x-generales.input-error :messages="$errors->first('inputUsuario')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['usuario'] }}" class="w-100" />
                @endif
            </div>
            <!-- Nombre -->
            <div class="my-1">
                <x-generales.zn-label for="inputNombre" :value="__('Nombre')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                @if($mostrar_form)
                    <x-generales.zn-input name="inputNombre" id="inputNombre" class="py-2 requerido-form-usuario" value="{{ isset($info_registro['nombre']) ? old('inputNombre', $info_registro['nombre']) : old('inputNombre')  }}" maxlength="500" />
                    <x-generales.input-error :messages="$errors->first('inputNombre')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['nombre'] }}" class="w-100" />
                @endif
            </div>
            <!-- Apellido -->
            <div class="my-1">
                <x-generales.zn-label for="inputApellido" :value="__('Apellido')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                @if($mostrar_form)
                    <x-generales.zn-input name="inputApellido" id="inputApellido" class="py-2 requerido-form-usuario" value="{{ isset($info_registro['apellido']) ? old('inputApellido', $info_registro['apellido']) : old('inputApellido') }}" maxlength="500" />
                    <x-generales.input-error :messages="$errors->first('inputApellido')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['apellido'] }}" class="w-100" />
                @endif
            </div>
            <!-- Encargado de -->
            <div class="my-1">
                <x-generales.zn-label for="selectEncargado" :value="__('Encargado de')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                @if($mostrar_form)
                    <select name="selectEncargado" id="selectEncargado" class="form-control form-input py-1 w-32 rounded requerido-form-usuario">
                        <option value="">SELECCIONE</option>
                        @foreach ($info_registro['array_encargadurias'] as $key_encargado => $encargado)
                            <option value="{{$encargado['id']}}" {{ old('selectEncargado', $info_registro['encargaduria_id']) == $encargado['id'] ? 'selected' : '' }} title="{{$encargado['descripcion']}}">{{$encargado['descripcion']}}</option>
                        @endforeach
                    </select>
                    {{-- <x-generales.zn-select :options="{{$info_registro['array_encargadurias']}}" :selectedOptions="{{isset($info_registro['encargado']) ? old('selectEncargado', $info_registro['encargado']) : old('selectEncargado')  }}" name="selectEncargado" class="py-2 " /> --}} 
                    
                    <x-generales.input-error :messages="$errors->first('selectEncargado')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['encargado'] }}" class="w-100" />
                @endif
            </div>
                <!-- Direccion -->
                <div class="my-1 block-unidades block-subdireccion block-direccion">
                    <x-generales.zn-label for="selectDireccion" :value="__('Dirección')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                    @if($mostrar_form)
                        <select name="selectDireccion" id="selectDireccion" class="form-control form-input py-1 w-32 rounded select-unidades select-subdireccion select-direccion">
                            <option value="">SELECCIONE</option>
                            @foreach ($info_registro['array_direcciones'] as $key_direccion => $direccion)
                                <option value="{{$direccion['id']}}" {{ old('selectDireccion', $info_registro['direccion_id']) == $direccion['id'] ? 'selected' : '' }} title="{{$direccion['descripcion']}}">{{$direccion['descripcion']}}</option>
                            @endforeach
                        </select>
                        
                        <x-generales.input-error :messages="$errors->first('selectDireccion')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['direccion'] }}" class="w-100" />
                    @endif
                </div>
                <!-- SubDireccion -->
                <div class="my-1 block-unidades block-subdireccion">
                    <x-generales.zn-label for="selectSubDireccion" :value="__('Sub-Dirección')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                    @if($mostrar_form)
                        <select name="selectSubDireccion" id="selectSubDireccion" class="form-control form-input py-1 w-32  select-unidades select-subdireccion rounded">
                            <option value="">SELECCIONE</option>
                        </select>
                        
                        <x-generales.input-error :messages="$errors->first('selectSubDireccion')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['subdireccion'] }}" class="w-100" />
                    @endif
                </div>
                <!-- Unidad -->
                <div class="my-1 block-unidades">
                    <x-generales.zn-label for="selectUnidad" :value="__('Unidad')" class="" requerido="{{in_array($tipo, $mostrar_input) ? 'true' : 'false'}}"  />
                    @if($mostrar_form)
                        <select name="selectUnidad" id="selectUnidad" class="form-control form-input py-1 w-32  select-unidades rounded">
                            <option value="">SELECCIONE</option>
                        </select>
                        
                        <x-generales.input-error :messages="$errors->first('selectUnidad')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $info_registro['unidad'] }}" class="w-100" />
                    @endif
                </div>
            <!-- Rut -->
            <div class="my-1">
                <x-generales.zn-label for="rutUsuario" :value="__('Rut')" class=" mr-0"  />
                @if($mostrar_form)
                <div class="flex">
                    <x-generales.zn-input name="rutUsuario" id="rutUsuario" class="py-2 max-w-xs" maxlength="500" onBlur="comprobarRut()" />
                    <div class="w-10 ms-5">
                        <x-generales.zn-input name="dvUsuario" id="dvUsuario" class="py-2 w-10" maxlength="500" onBlur="comprobarRut()" />
                    </div>
                    <input type="hidden" id='rutValidado'>
                </div>
                    <span class="hidden text-red-600 space-y-1 msg-error-rut mt-2" id="msgUsuario"></span>
                    <x-generales.input-error :messages="$errors->first('rutUsuario')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['apellido'] }}" class="w-100" />
                @endif
            </div>
            <!-- Telefono -->
            <div class="my-1">
                <x-generales.zn-label for="inputTelefono" :value="__('Teléfono')" class="" />
                @if($mostrar_form)
                    <div class="grid grid-cols-6 gap-6 flex">
                        <div class="lg:col-span-2 col-span-3 me-1 flex">
                            <span class="me-3 pt-1 text-gray-600">(+56)</span>
                            <x-generales.zn-select-telefono name="digito" id="digito" class="w-16" value="{{  isset($info_registro['digito']) ? old('digito', $info_registro['digito'] ) : old('digito') }}" />
                        </div>
                        <x-generales.zn-input type="text" name="inputTelefono" id="inputTelefono" class="lg:col-span-4 col-span-3" value="{{  isset($info_registro['telefono']) ? old('inputTelefono', $info_registro['telefono']) : old('inputTelefono')  }}" maxlength="8" />
                    </div>
                    <x-generales.input-error :messages="$errors->first('inputTelefono')" class="mt-2" />
                    <x-generales.input-error :messages="$errors->first('digito')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ ! empty($info_registro['telefono']) ? '(+56)' . $info_registro['digito']. ' ' . $info_registro['telefono'] : '' }} " class="w-100" />
                @endif
            </div>
            <!-- Cargo -->
            <div class="my-1">
                <x-generales.zn-label for="inputCargo" :value="__('Cargo')" class=""  />
                @if($mostrar_form)
                    <x-generales.zn-input name="inputCargo" id="inputCargo" class="py-2" maxlength="500" />
                    <x-generales.input-error :messages="$errors->first('inputCargo')" class="mt-2" />
                @else
                    <x-generales.zn-mostrar-datos value="{{ $info_registro['cargo'] }}" class="w-100" />
                @endif
            </div>
            <!-- Cargo -->
            <div class="my-1">
            </div>
            <!-- Estado -->
            @if(in_array($tipo, $mostrar_estado))
                <div class="my-1">
                    <x-generales.zn-label for="inputEstado" :value="__('Estado')" class="" maxlength="150" />
                    @if($mostrar_form)
                        <input name="inputEstado" id="inputEstado" type="hidden" value="{{ isset($info_registro['estado_id']) ? old('inputEstado', $info_registro['estado_id']) : old('inputEstado') }}" />
                        <x-generales.zn-toggle name="inputEstados" descripcion="{{ $info_registro['estado'] }}" value="{{ isset($info_registro['estado_id']) ? old('inputEstado', $info_registro['estado_id']) : old('inputEstado') }}" />
                        <x-generales.input-error :messages="$errors->first('inputEstado')" class="mt-2" />
                    @else
                        <div class="w-48">
                            <x-generales.zn-badge-estado texto="{{ $info_registro['estado'] }}" class="{{ $info_registro['css_estado'] }}" />
                        </div>
                    @endif
                </div> 
            @endif
        </div>
        

        <div class="mt-6 flex items-center justify-end gap-x-6">
            @if($tipo != 'visualizar')
                <x-generales.zn-btn-enviar value="Guardar" />
            @endif
            <x-generales.zn-btn-cancelar value="Cancelar" href="{{ route('mi-institucion/usuarios')}}" />
        </div>
    </div>
</form>