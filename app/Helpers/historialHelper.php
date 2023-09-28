<?php

/**
 * Archivo que contendrá las funciones globales, la cuales podrán sera llamadas
 * desde cualquier parte de la plataforma
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Models\Administracion\Configuracion\AdministracionDocumentoAccion;
use App\Models\Administracion\Configuracion\AdministracionDocumentoEtapa;
use App\Models\Administracion\Configuracion\AdministracionTipoDocumento;
use App\Models\Administracion\Configuracion\AdministracionDocumentoEstado;
use App\Models\Historial\Historial;
use App\Models\Historial\HistorialListado;
use App\Models\Historial\HistorialRegistro;
use App\Models\Historial\HistorialRegistroListado;
use App\Models\Historial\HistorialCambio;
use App\Models\Historial\HistorialListadoCambio;
use App\Models\General\Estado;
use App\Models\General\Region;
use App\Models\General\Comuna;
use App\Models\MiEmpresa\Unidad;
use App\Models\MiEmpresa\Subunidad;
use App\Models\MiInstitucion\Direccion;
use App\Models\MiInstitucion\SubDireccion;
use App\Models\MisDocumentos\DocumentoEstado;
use App\Models\User\UserEstado;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


 mb_internal_encoding('UTF-8');
 mb_regex_encoding("UTF-8");
 
Carbon::setLocale('es');

/**
 * Funcion que permite validar la acción que se esta efecutando y así registrar en la tabla correspondiente.
 * @param  boolean $historial_accion        [accion]
 * @param  boolean $modulo_id               ID del modulo (zona - sucursal - usuario ... etc)]
 * @param  boolean $historial_tipo_registro [tipo de registro]
 * @param  boolean $descripcion             [descripcion de la accion]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registroHistorialRegistro($historial_accion = false, $modulo_id = false, $historial_tipo_registro = false, $descripcion = false, $campos_editados = array(), $lista = false, $multiple_lista = false, $nuevo_tipo_registro = false)
{
    /**
     * Registro en la tabla
     */
    if ($historial_accion == 1) { //  1: Nuevo registro

        $historial_registro = new HistorialRegistro;
        $historial_registro->descripcion = $descripcion;
        $historial_registro->listados = existe($campos_editados['listados_tipo_registro']);
        $historial_registro->historial_registro = existe($modulo_id);
        $historial_registro->historial_tipo_registro_id = existe($historial_tipo_registro);
        $historial_registro->cliente_id = session('plataforma.user.cliente.id');

        if ($historial_registro->save()) {

             $historial_registro_insertId = $historial_registro->id;
             registrarHistorial($historial_registro_insertId, $historial_accion);

             if ($lista && !empty($campos_editados['campos_lista_add'])) {
                resgistrarHistoriaResgistrolListado($historial_registro_insertId, $historial_accion, $historial_tipo_registro, $campos_editados);

            }
        }

    }
    else if ( $historial_accion == 2 ) { // 3: Borrar registro

         $historial_registro = HistorialRegistro::where([
                                    ['historial_registro', $modulo_id],
                                    ['historial_tipo_registro_id', $historial_tipo_registro]
                                ])->first();

        $historial_registro_id = $historial_registro->id;
        registrarHistorial($historial_registro_id, $historial_accion);

    }
    else if ( $historial_accion == 3 ) { // 3: Edicion de registro

        // Se obtiene el ID del historial registro asociado
        $historial_registro = HistorialRegistro::where([
                                ['historial_registro', $modulo_id],
                            ]);
        if (  $nuevo_tipo_registro &&  $nuevo_tipo_registro != $historial_tipo_registro) {

            $historial_registro = $historial_registro->whereIn('historial_tipo_registro_id', [$nuevo_tipo_registro, $historial_tipo_registro])
                                ->first();
        } else {
            $historial_registro = $historial_registro->where('historial_tipo_registro_id', $historial_tipo_registro)
                                ->first();
        }

        $historial_registro_id = $historial_registro->id;
        $historial_id = registrarHistorial($historial_registro_id, $historial_accion, $campos_editados);
        $tipo_registro_cambiar = ( ! $nuevo_tipo_registro ? $historial_tipo_registro : $nuevo_tipo_registro);
        actualizarDescripcionHistorial($historial_registro_id, $descripcion, $tipo_registro_cambiar);

        if($lista && ( !empty($campos_editados['campos_lista_add']) || !empty($campos_editados['campos_lista_delete']) || !empty($campos_editados['datos_editados']))) {

            resgistrarHistoriaResgistrolListado($historial_registro_id, $historial_accion, $historial_tipo_registro, $campos_editados, $historial_id);

        }
    }
    else if ( $historial_accion == 200 ) { // 4: Nuevo registro Listado

        $historial_accion = 3;
        // Se obtiene el ID del historial registro asociado
        $historial_registro = HistorialRegistro::where([
                                ['historial_registro', $modulo_id],
                                ['historial_tipo_registro_id', $historial_tipo_registro]
                            ])->first();
        $historial_registro_id = $historial_registro->id;
        registrarHistorialListadoIndividual($historial_registro_id, $historial_accion, $campos_editados, false, $historial_tipo_registro);

    }
    else if ( $historial_accion == 201 ) { // 5: Editar registro Listado
        
        $historial_accion = 3;
        // Se obtiene el ID del historial registro asociado
        $historial_registro = HistorialRegistro::where([
                                ['historial_registro', $modulo_id],
                                ['historial_tipo_registro_id', $historial_tipo_registro]
                            ])->first();
        $historial_registro_id = $historial_registro->id;
        registrarHistorialListadoIndividual($historial_registro_id, $historial_accion, $campos_editados, true, $historial_tipo_registro);


    }
    else if ( $historial_accion == 202 ) { // 6: Borrar registro Listado
        
        $historial_accion = 3;
        // Se obtiene el ID del historial registro asociado
        $historial_registro = HistorialRegistro::where([
                                ['historial_registro', $modulo_id],
                                ['historial_tipo_registro_id', $historial_tipo_registro]
                            ])->first();

        $historial_registro_id = $historial_registro->id;
        registrarHistorialListadoIndividual($historial_registro_id, $historial_accion, $campos_editados, false, $historial_tipo_registro);

    }
    elseif ( ! $historial_accion ) { //  1: Nuevo registro Portal

        $historial_registro = new HistorialRegistro;
        $historial_registro->descripcion = $descripcion;
        $historial_registro->listados = existe($campos_editados['listados_tipo_registro']);
        $historial_registro->historial_registro = existe($modulo_id);
        $historial_registro->historial_tipo_registro_id = existe($historial_tipo_registro);
        $historial_registro->cliente_id = env('CLIENTE_ACTIVO');

        if ($historial_registro->save()) {

             $historial_registro_insertId = $historial_registro->id;
             registrarHistorial2($historial_registro_insertId, $historial_accion);
        }

    }
    else { //  El resto de los registros

        // Se obtiene el ID del historial registro asociado
        $historial_registro = HistorialRegistro::where([
                                ['historial_registro', $modulo_id],
                                ['historial_tipo_registro_id', $historial_tipo_registro]
                            ])->first();
        $historial_registro_id = $historial_registro->id;
        actualizarDescripcionHistorial($historial_registro_id, $descripcion);
        registrarHistorialListadoIndividual($historial_registro_id, $historial_accion, $campos_editados, false, $historial_tipo_registro);


    }
}


/**
 * Funcion que permite validar el tipo de informacion que será registrada en la tabla historialRegistroListado
 * @param  boolean $historial_registro_insertId [Identificador del registro]
 * @param  boolean $historial_accion            [tipo de accion]
 * @param  boolean $historial_tipo_registro     [tipo de registro]
 * @param  array   $campos_editados                  [arreglo con los campos que se han cambiado]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function resgistrarHistoriaResgistrolListado( $historial_registro_insertId = false, $historial_accion = false, $historial_tipo_registro = false, $campos_editados = array(), $historial_id = null )
{
    if ($historial_registro_insertId) {

        if ( !empty($campos_editados['campos_lista_add'])) {

            foreach ($campos_editados['campos_lista_add'] as $key_lista_add => $campos_lista_add) {

                $accion_listado = $campos_lista_add['tipo_registro'];

                foreach ($campos_lista_add['lista'] as $key_lista => $lista) {

                    $historial_registro_listado = new HistorialRegistroListado;
                    $historial_registro_listado->descripcion = $lista['nombre'];
                    $historial_registro_listado->cliente_id = session('plataforma.user.cliente.id');
                    $historial_registro_listado->historial_registro_id = $historial_registro_insertId;
                    $historial_registro_listado->historial_tipo_registro_id = $accion_listado;

                    if ($historial_registro_listado->save()) {

                         $historial_registro_listado_insertId = $historial_registro_listado->id;
                         resgistrarHistorialListado(1, $historial_registro_listado_insertId, $historial_id);

                    }
                }
            }
        }

        if (!empty($campos_editados['campos_lista_delete'])) {

            foreach ($campos_editados['campos_lista_delete'] as $key_lista_add => $campos_lista_delete) {

                $accion_listado_delete = $campos_lista_delete['tipo_registro'];

                foreach ($campos_lista_delete['lista'] as $key_lista => $lista) {

                    $historial_registro_listado =  HistorialRegistroListado::where([
                                                    ['descripcion', $lista['nombre']],
                                                    ['cliente_id', session('plataforma.user.cliente.id')],
                                                    ['historial_registro_id', $historial_registro_insertId],
                                                    ['historial_tipo_registro_id', $accion_listado_delete]
                                                ])->first();

                    $historial_registro_listado_insertId = $historial_registro_listado->id;

                    resgistrarHistorialListado(2, $historial_registro_listado_insertId, $historial_id, $lista);

                }
            }
        }

        if (!empty($campos_editados['datos_editados'])) {

            foreach ($campos_editados['datos_editados'] as $key_lista_add => $datos_editados) {

                if ( isset($datos_editados['tipo_registro']) ) {

                    $accion_listado_editado = $datos_editados['tipo_registro'];

                    foreach ($datos_editados['lista'] as $key_lista => $lista) {

                        $historial_registro_listado =  HistorialRegistroListado::where([
                                                        ['descripcion', $lista['nombre']],
                                                        ['cliente_id', session('plataforma.user.cliente.id')],
                                                        ['historial_registro_id', $historial_registro_insertId],
                                                        ['historial_tipo_registro_id', $accion_listado_editado]
                                                    ])->first();
                        $historial_registro_listado->descripcion = $lista['descripcion'];
                        $historial_registro_listado->save();
                        $historial_registro_listado_insertId = $historial_registro_listado->id;

                        resgistrarHistorialListado(3, $historial_registro_listado_insertId, $historial_id, $lista);
                        // registrarHistorialListadoIndividual($historial_registro_insertId, 3, $lista, true, $accion_listado_editado);

                    }
                }
            }
        }
    }

    return false;
}


/**
 * Funcion que permite registrar datos en la tabla historial cambios
 * @param  boolean $historial_registro_insertId [Identificador del historial registro]
 * @param  boolean $historial_accion            [accione que se está realizando]
 * @param  array   $campos_editados             [arreglo con los campos editados]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registrarHistorial($historial_registro_insertId = false, $historial_accion = false, $campos_editados = array(), $historial_cambios = true)
{
    if ($historial_registro_insertId) {

        $historial = new Historial;
        $historial->ip = getRealIP();
        $historial->user_id = Auth::user()->id;
        $historial->cliente_id = session('plataforma.user.cliente.id');
        $historial->historial_accion_id = $historial_accion;
        $historial->historial_registro_id = $historial_registro_insertId;

        if ($historial->save()) {

            $historial_insertId     = $historial->id;

            if(! empty($campos_editados) && $historial_accion == 3 && $historial_cambios) {

                registrarHistorialCambios($campos_editados, $historial_insertId);

            }

            return $historial_insertId;
        }
    }

    return false;
}


/**
 * Funcion que permite registrar datos en la tabla historial cambios Sin Sesion
 * @param  boolean $historial_registro_insertId [Identificador del historial registro]
 * @param  boolean $historial_accion            [accione que se está realizando]
 * @param  array   $campos_editados             [arreglo con los campos editados]
 * @date    12-09-2022
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */
function registrarHistorial2($historial_registro_insertId = false, $historial_accion = false, $campos_editados = array(), $historial_cambios = true)
{
    if ($historial_registro_insertId) {

        $historial = new Historial;
        $historial->ip = getRealIP();
        $historial->user_id = null;
        $historial->cliente_id = env('CLIENTE_ACTIVO');
        $historial->historial_accion_id = 1;
        $historial->historial_registro_id = $historial_registro_insertId;

        if ($historial->save()) {

            $historial_insertId     = $historial->id;

            if(! empty($campos_editados) && $historial_accion == 3 && $historial_cambios) {

                registrarHistorialCambios($campos_editados, $historial_insertId);

            }

            return $historial_insertId;
        }
    }

    return false;
}

/**
 * Funcion que permite registrar datos en la tabla historial cambios
 * @param  boolean $historial_registro_insertId [Identificador del historial registro]
 * @param  boolean $historial_accion            [accione que se está realizando]
 * @param  array   $campos_editados             [arreglo con los campos editados]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registrarHistorialPagina($historial_registro_insertId = false, $historial_accion = false, $campos_editados = array(), $historial_cambios = true)
{
    if ($historial_registro_insertId) {

        $historial = new Historial;
        $historial->ip = getRealIP();
        $historial->user_id = 1;
        $historial->cliente_id = env('CLIENTE_ACTIVO');
        $historial->historial_accion_id = $historial_accion;
        $historial->historial_registro_id = $historial_registro_insertId;

        $historial->save();
        return $historial->id;
    }

    return false;
}


/**
 * Funcion que permite regitrar datos en la tabla historial listado
 * @param  boolean $accion                              [accion que se está realizando]
 * @param  boolean $historial_registro_listado_insertId [Identificador historial registro listado]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function resgistrarHistorialListado($accion = false, $historial_registro_listado_insertId = false, $historia_padre_id = 0, $campos_editados = array() )
{
    if($historial_registro_listado_insertId) {

        $historialListado = new HistorialListado;
        $historialListado->cliente_id = session('plataforma.user.cliente.id');
        $historialListado->historial_accion_id = $accion;
        $historialListado->historial_registro_listado_id = $historial_registro_listado_insertId;
        $historialListado->historial_id = $historia_padre_id ;

        $historialListado->save();

        if( ! empty($campos_editados) && $accion == 3 ) {

            registrarHistorialCambiosListadoIndividual($campos_editados, $historialListado->id);

        }
    }

    return false;
}


/**
 * Funcion que permite regitrar datos en la tabla historial cambios
 * @param  array   $campos_editados    [campos que fueron editados]
 * @param  boolean $historial_insertId [identificador historial]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registrarHistorialCambios($campos_editados = array(), $historial_insertId = false)
{
    if($campos_editados['cambios']) {
        
        if ( isset($campos_editados['campos']) ) {

            foreach($campos_editados['campos'] as $key => $campo) {
                try {
                    $historialCambio                      = new HistorialCambio;
                    $historialCambio->historial_id        = $historial_insertId;
                    $historialCambio->historial_label_id  = $campo['label'];
                    $historialCambio->anterior            = $campo['valor_antiguo'];
                    $historialCambio->nuevo               = $campo['valor_nuevo'];            
                    $historialCambio->save();
                } catch (\Exception $e) {
                }
            }

        }
    }
}


/**
 * Funcion que permite actualizar la descripcion del modulo
 * @date Ago 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function actualizarDescripcionHistorial($historial_registro_id = false, $descripcion = false, $tipo_registro = false)
{
    if ($historial_registro_id) {

        $historial_registro = HistorialRegistro::find($historial_registro_id);
        $historial_registro->descripcion = $descripcion;
        if($tipo_registro){
            $historial_registro->historial_tipo_registro_id = $tipo_registro;
        }
        $historial_registro->save();
    }
}


/**
 * Funcion que permite registrar datos en la tabla historial cambios
 * @param  boolean $historial_registro_insertId [Identificador del historial registro]
 * @param  boolean $historial_accion            [accione que se está realizando]
 * @param  array   $campos_editados             [arreglo con los campos editados]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registrarHistorialListadoIndividual($historial_registro_insertId = false, $historial_accion = false, $campos_editados = array(), $historial_cambios = true)
{
    if ($historial_registro_insertId) {

        $historial = new Historial;
        $historial->ip = getRealIP();
        $historial->user_id = Auth::user()->id;
        $historial->cliente_id = session('plataforma.user.cliente.id');
        $historial->historial_accion_id = $historial_accion;
        $historial->historial_registro_id = $historial_registro_insertId;

        if ($historial->save()) {

            $historial_insertId = $historial->id;
            if( ! empty($campos_editados) ) {
                resgistrarHistoriaResgistrolListadoIndividual($historial_registro_insertId, $historial_accion, false, $campos_editados, $historial_insertId);

            }
        }
    }

    return false;
}


/**
 * Funcion que permite validar el tipo de informacion que será registrada en la tabla historialRegistroListado
 * @param  boolean $historial_registro_insertId [Identificador del registro]
 * @param  boolean $historial_accion            [tipo de accion]
 * @param  boolean $historial_tipo_registro     [tipo de registro]
 * @param  array   $campos_editados                  [arreglo con los campos que se han cambiado]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function resgistrarHistoriaResgistrolListadoIndividual ( $historial_registro_insertId = false, $historial_accion = false, $historial_tipo_registro = false, $campos_editados = array(),  $historial_insertId = false)
{
    if ($historial_registro_insertId) {

        if ( !empty($campos_editados['campos_lista_add']) ) {

            $accion = 1;

        }

        if (!empty($campos_editados['campos_lista_delete'])) {

            $accion = 2;
        }

        if (!empty($campos_editados['campos_lista_edit'])) {

            $accion = 3;
        }

        if (!empty($campos_editados['campos_lista_aprob'])) {

            $accion = 30;
        }

        if ($accion == 1) {
            $historial_registro_listado = prepararHistorialRegistroListado($historial_registro_insertId, $historial_accion, $historial_tipo_registro, $campos_editados,  $historial_insertId);
        } else {
            $historial_registro_listado =  HistorialRegistroListado::where([
                                            ['cliente_id', session('plataforma.user.cliente.id')],
                                            ['registro_id', $campos_editados['registro_id']],
                                            ['historial_tipo_registro_id', $campos_editados['listados_tipo_registro']]
                                        ])->first();
            if ($historial_registro_listado) {
                $historial_registro_listado->descripcion = $campos_editados['descripcion'];
            } else {
                $historial_registro_listado = prepararHistorialRegistroListado($historial_registro_insertId, $historial_accion, $historial_tipo_registro, $campos_editados,  $historial_insertId);
            }
        }

        if ($historial_registro_listado->save()) {

            $historial_registro_listado_insertId = $historial_registro_listado->id;
            resgistrarHistorialListado($accion, $historial_registro_listado_insertId, $historial_insertId, $campos_editados);

        }
    }

    return false;
}

function prepararHistorialRegistroListado($historial_registro_insertId = false, $historial_accion = false, $historial_tipo_registro = false, $campos_editados = array(),  $historial_insertId = false){
    $historial_registro_listado = new HistorialRegistroListado;
    $historial_registro_listado->descripcion = $campos_editados['descripcion'];
    $historial_registro_listado->cliente_id = session('plataforma.user.cliente.id');
    $historial_registro_listado->historial_registro_id = $historial_registro_insertId;
    $historial_registro_listado->registro_id = $campos_editados['registro_id'];
    $historial_registro_listado->historial_tipo_registro_id = $campos_editados['listados_tipo_registro'];
    return $historial_registro_listado;
}


/**
 * Funcion que permite regitrar datos en la tabla historial cambios
 * @param  array   $campos_editados    [campos que fueron editados]
 * @param  boolean $historial_insertId [identificador historial]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function registrarHistorialCambiosListadoIndividual ($campos_editados = array(), $historial_insertId = false)
{

    if($campos_editados['datos_editados']['cambios']) {

        foreach($campos_editados['datos_editados']['campos'] as $key => $campo) {

            try {

                $historialCambio = new HistorialListadoCambio;
                $historialCambio->historial_listado_id = $historial_insertId;
                $historialCambio->historial_label_id  = $campo['label'];
                $historialCambio->anterior = quitarSaltoLinea($campo['valor_antiguo'], 249, false);
                $historialCambio->nuevo = quitarSaltoLinea($campo['valor_nuevo'], 249, false);
       
                $historialCambio->save();

            } catch (\Exception $e) {

            }
        }
    }
}


/**
 * Funcion que permite comparar los campos de los arreglos
 * @param  array  $modulo         [campos registrados en la base de datos]
 * @param  array  $request_campos [campos enviados desde el formulario]
 * @param  array  $campos         [campos que se deben comparar]
 * @return [type]                 [arreglo con los campos que se modificador]
 *  @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 *
 * @modified Abril 2020
 * param  array  $label          [ID historial label]
 */
function comprobarCambios($modulo = array(), $request_campos = array(), $campos = array(), $label = array())
{
    $response['cambios'] =  false;
    $response['campos'] =  array();

    if(!empty($modulo) && !empty($request_campos && !empty($campos))) {

        foreach($campos as $key => $campo) {

            //if ($modulo[$campo] != $request_campos[$campo]) {
            if(strcasecmp($modulo[$campo], $request_campos[$campo])) {

                $campo_diferente['label'] = $label[$key];
                $campo_diferente['campo'] = $campo;
                $campo_diferente['valor_antiguo'] = $modulo[$campo];
                $campo_diferente['valor_nuevo'] = $request_campos[$campo];
                array_push($response['campos'], $campo_diferente);
                $response['cambios'] =  true;

            }
        }
    }

    return $response;
}


/**
 * Funcion que permite comparar los valores de 2 array.
 * Para este caso se compara los datos que no estan
 * @param  array   $array_matriz_1 [array principal]
 * @param  array   $array_matriz_2 [array secundario]
 * @param  boolean $index          [array con key para comparar]
 *  @date  Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function compararBorrados($array_matriz_1 = array(), $array_matriz_2 = array(), $index = false)
{
    if (! empty($array_matriz_1) && !empty($array_matriz_2)) {

        $response = array();
        $response['diff'] = false;
        $response['elemento_diff'] = array();

        foreach($array_matriz_1 as $key_matriz_1 => $matriz_1) {

            foreach($array_matriz_2 as $key_matriz_2 => $matriz_2) {

                if($matriz_2[$index] != $matriz_1 [$index]) {

                    $response['diff'] = true;
                    array_push($response['elemento_diff'], $matriz_2);

                }
            }
        }

        return $response;

    }
    return false;
}


/**
 * Funcion que permite obtener el nombre del modulo (relacion bbdd) que tuve cambios en su edicción por formulario
 * @param  array  $is_cambios [array con las relaciones que han cambiado]
 * @date Julio
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function nombresRelacionesCambios($is_cambios = [])
{
    if (! empty($is_cambios)) {

        $booleano = array("1" => "SI", "0" => "NO");

        foreach ($is_cambios as $key_campos => $campo) {

            // Para Region
            if ($campo['label'] == 100) {
                // Valor Antiguo
                $nombre_region_antiguo =  ( !empty($campo['valor_antiguo']) ? Region::nombreId($campo['valor_antiguo']) : '' );
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_region_antiguo;
                // Valor Nuevo
                $nombre_region_nuevo =  ( !empty($campo['valor_nuevo']) ? Region::nombreId($campo['valor_nuevo']) : '' );
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_region_nuevo;
            }

            // Para Comuna
            if ($campo['label'] == 200) {
                // Valor Antiguo
                $nombre_comuna_antiguo =  ( !empty($campo['valor_antiguo']) ? Comuna::nombreId($campo['valor_antiguo']) : '' );
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_comuna_antiguo;
                // Valor Nuevo
                $nombre_comuna_nuevo =  ( !empty($campo['valor_nuevo']) ? Comuna::nombreId($campo['valor_nuevo']) : '' );
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_comuna_nuevo;
            }

            // Para Unidad
            // if( $campo['label'] == 16 ){
            //     // Valor Antiguo
            //     $nombre_unidad_antiguo =  Unidad::nombreId($campo['valor_antiguo']);
            //     $is_cambios[$key_campos]['valor_antiguo'] = $nombre_unidad_antiguo;
            //     // Valor Nuevo
            //     $nombre_unidad_nuevo =  Unidad::nombreId($campo['valor_nuevo']);
            //     $is_cambios[$key_campos]['valor_nuevo'] = $nombre_unidad_nuevo;
            // }
            // Para SubDireccion
            if( $campo['label'] == 11 ){
                // Valor Antiguo
                $nombre_unidad_antiguo =  SubDireccion::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_unidad_antiguo;
                // Valor Nuevo
                $nombre_unidad_nuevo =  SubDireccion::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_unidad_nuevo;
            }
            // Para Direccion Módulo
            if( $campo['label'] == 30 ){
                // Valor Antiguo
                $nombre_unidad_antiguo =  Direccion::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_unidad_antiguo;
                // Valor Nuevo
                $nombre_unidad_nuevo =  Direccion::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_unidad_nuevo;
            }

            // Para Estado Documento
            if( $campo['label'] == 5 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  Estado::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  Estado::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }


            // Para Estado
            if( $campo['label'] == 24 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  AdministracionDocumentoEstado::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  AdministracionDocumentoEstado::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }
            // Para Estado MisDocumento
            if( $campo['label'] == 28 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  DocumentoEstado::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  DocumentoEstado::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }

            // Para Estado Usuario
            if( $campo['label'] == 6 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  UserEstado::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  UserEstado::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }

            // Para Accion
            if( $campo['label'] == 20 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  AdministracionDocumentoAccion::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  AdministracionDocumentoAccion::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }

            // Para Etapa
            if( $campo['label'] == 21 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  AdministracionDocumentoEtapa::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  AdministracionDocumentoEtapa::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }

            // Para tipo_documento
            if( $campo['label'] == 23 ){
                // Valor Antiguo
                $nombre_estado_antiguo =  AdministracionTipoDocumento::nombreId($campo['valor_antiguo']);
                $is_cambios[$key_campos]['valor_antiguo'] = $nombre_estado_antiguo;
                // Valor Nuevo
                $nombre_estado_nuevo =  AdministracionTipoDocumento::nombreId($campo['valor_nuevo']);
                $is_cambios[$key_campos]['valor_nuevo'] = $nombre_estado_nuevo;
            }


            // Campos Booleanos
            if ( in_array($campo['label'], [17, 18, 19, 22, 26, 27], true ) ) {
                // Valor Antiguo
                $campo['valor_antiguo'] = existe($campo['valor_antiguo'],'int');
                $dato_antiguo =  $booleano[$campo['valor_antiguo']];
                $is_cambios[$key_campos]['valor_antiguo'] = $dato_antiguo;
                // Valor Nuevo
                $campo['valor_nuevo'] = existe($campo['valor_nuevo'],'int');
                $dato_nuevo =  $booleano[$campo['valor_nuevo']];
                $is_cambios[$key_campos]['valor_nuevo'] = $dato_nuevo;
            }

            // Campos Nros
            if ( in_array($campo['label'], [], true ) ) {
                // Valor Antiguo
                $campo['valor_antiguo'] = 'N° '. existe($campo['valor_antiguo'],'int');
                $is_cambios[$key_campos]['valor_antiguo'] = $campo['valor_antiguo'];
                // Valor Nuevo
                $campo['valor_nuevo'] = 'N° '. existe($campo['valor_nuevo'],'int');
                $is_cambios[$key_campos]['valor_nuevo'] = $campo['valor_nuevo'];
            }


            // Campos Fechas
            if ( in_array($campo['label'], [], true ) ) {
                // Valor Antiguo
                $campo['valor_antiguo'] = existe($campo['valor_antiguo']);
                $dato_antiguo =  Carbon::createFromFormat('Y-m-d', $campo['valor_antiguo'])->format('d-m-Y');
                $is_cambios[$key_campos]['valor_antiguo'] = $dato_antiguo;
                // Valor Nuevo
                $campo['valor_nuevo'] = existe($campo['valor_nuevo']);
                $dato_nuevo =  Carbon::createFromFormat('Y-m-d', $campo['valor_nuevo'])->format('d-m-Y');;
                $is_cambios[$key_campos]['valor_nuevo'] = $dato_nuevo;
            }

        }

        return $is_cambios;
    }

   return $is_cambios;
}


/**
 * Funcion que permite obtener el listado de las opciones de acciones,
 * para el filtro de acciones del historial
 * @return [type] [description]
 */
function accionesFiltroHistorial($modulo)
{
    $select_accion = ":";

    if ($modulo == 'miempresa') {

        $select_accion = ':;AGREGAR:AGREGAR;EDITAR:EDITAR;BORRAR:BORRAR';

    }
    else if ($modulo == 'configuraciones') {

        $select_accion = ':;AGREGAR:AGREGAR;EDITAR:EDITAR;BORRAR:BORRAR';

    }

    else {

        $select_accion = '';

    }

    return $select_accion;
}