<form class="w-full" id="form-usuario-accesos" accept-charset="UTF-8" enctype="multipart/form-data" >
    <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
    <div class="space-y-8 grid-cols-1 w-full xl:w-3/5">
        @foreach ($modulos as $key_modulo => $modulo)
            <!-- <x-generales.zn-dsc-modulo value="{{ $modulo['modulo'] ?? 'Módulo'}}" /> -->
            <div class="lg:grid lg:grid-cols-2  lg:gap-y-2 lg:gap-x-12">
                <div class="my-1">
                    <x-generales.zn-label for="selectDireccion{{$modulo['id']}}" :value="__($modulo['modulo'])" class=""  />
                    @if($mostrar_form)
                        <select name="selectDireccion{{$modulo['id']}}" id="selectDireccion{{$modulo['id']}}" class="form-control form-input py-1 w-32 rounded select-accesos-usuarios">
                            <option value="">SELECCIONE</option>
                            @foreach ($tipo_accesos as $key_accesos => $accesos)
                                <option value="{{$accesos['id']}}" data-modulo-acceso="{{$modulo['id']}}" {{ $modulo['tipo'] == $accesos['id'] ? 'selected' : '' }} title="{{$accesos['descripcion']}}">{{$accesos['descripcion']}}</option>
                            @endforeach
                        </select>
                        
                        <x-generales.input-error :messages="$errors->first('selectDireccion')" class="mt-2" />
                    @else
                        <x-generales.zn-mostrar-datos value="{{ $modulo['dsc_tipo'] }}" class="w-100 lg:w-2/3" />
                    @endif
                </div>
                
                @foreach ($submodulos as $key_submodulo => $submodulo)
                    @if( $submodulo['padre'] == $modulo['modulo_id'] )
                        <div class="my-1">
                            <x-generales.zn-label for="selectDireccion{{$submodulo['id']}}" :value="__($submodulo['modulo'])" class=""  />
                            @if($mostrar_form)
                                <select name="selectDireccion{{$submodulo['id']}}" id="selectDireccion{{$submodulo['id']}}" class="form-control form-input py-1 w-32 rounded select-accesos-usuarios">
                                    <option value="">SELECCIONE</option>
                                    @foreach ($tipo_accesos as $key_accesos => $accesos)
                                        <option value="{{$accesos['id']}}" data-modulo-acceso="{{$submodulo['id']}}" {{ $submodulo['tipo'] == $accesos['id'] ? 'selected' : '' }} title="{{$accesos['descripcion']}}">{{$accesos['descripcion']}}</option>
                                    @endforeach
                                </select>
                                
                                <x-generales.input-error :messages="$errors->first('selectDireccion')" class="mt-2" />
                            @else
                                <x-generales.zn-mostrar-datos value="{{ $submodulo['dsc_tipo'] }}" class="w-100 lg:w-2/3" />
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <hr class="mb-3">
        @endforeach
        <input type="hidden" name="inputDatosAcccesos" id="inputDatosAcccesos" value="" />
        <input type="hidden" name="inputRegistrosAcccesos" id="inputRegistrosAcccesos" value="" />
        <div class="mt-6 flex items-center justify-end gap-x-6">
            @if($tipo != 'visualizar')
                <x-generales.zn-btn-enviar value="Guardar" type="button" class="btn-guardar-accesos" />
            @endif
            <x-generales.zn-btn-cancelar value="Cancelar" href="{{ route('mi-institucion/usuarios')}}" />
        </div>
    </div>
</form>