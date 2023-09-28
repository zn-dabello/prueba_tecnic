<?php

/**
 * Archivo que contendrá las funciones globales, la cuales podrán sera llamadas
 * desde cualquier parte de la plataforma
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Models\General\SistemaAlerta;
use App\Models\General\Estado;
use App\Models\General\Region;
use App\Models\General\Comuna;
use App\Models\MiEmpresa\Unidad;
use App\Models\MiEmpresa\Subunidad;
use App\Models\User\UserEstado;
use App\Models\Administracion\ConfiguracionTrabajadores\PeriodicidadReporte;
use App\Models\Administracion\ConfiguracionContratistas\TipoContratista;
use App\Models\Administracion\ConfiguracionContratistas\ProveedorTipo;
use App\Models\Administracion\ConfiguracionTrabajadores\TipoFrecuencia;
use App\Models\Administracion\GastoComun\Mes;
use App\Models\Administracion\GastoComun\Departamento;
use App\Models\Aplicacion\Aplicacion;
use App\Models\Portal\MenuAccion;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


 mb_internal_encoding('UTF-8');
 mb_regex_encoding("UTF-8");
 
Carbon::setLocale('es');



/**
 * Función que permite agregarle la versión a los archivos externos, esta versíón será la
 * fecha en que se modificó
 * @param $path
 * @param null $secure
 * @return string
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
*/
function versionedAsset($path, $secure = null)
{
    $timestamp = @filemtime(public_path($path)) ?: 0;
    return asset($path, $secure) . '?zn=' . $timestamp;
    // $path_url = explode('.', $path);
    // $extension = end($path_url);
    // $dir = "";
    // foreach ($path_url as $paths => $value) {

    //     $dir = ($value == $extension) ? $dir.'.'.$timestamp.'.'.$value : $dir.$value;
    // }
    // return asset($dir, $secure);
}

/**
 * Funcion que permite encriptar una cade de texto
 * @return [encript]         [cadena encriptada]
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function encriptText($texto = false)
{
    if($texto) {
        $encript = hash_hmac('ripemd160', $texto, 'secret');
        return $encript;
    }

    return false;
}


/**
 * Funcion que permite obtener el nombre de una imagen determinada de un cliente
 * @param [type] $id_cliente [Identificador del cliente]
 * @param [type] $tipo [tipo de imagen, Ejm: logo - logo email - logo reporte ... ]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 * @ejemplo
 *     imagenCliente(session('plataforma.user.cliente.id'), 'logo')
 */
function imagenCliente($id_cliente = null, $tipo = null)
{
    if($id_cliente && $tipo) {

        $nombre = sprintf('%d|%s|%s',$id_cliente,imgCliente($id_cliente,'time_logo'),$tipo);
        $nombre = hash_hmac('ripemd160', $nombre, 'secret');
        return $nombre;
    }

    return false;
}


/**
 * Funcion que permite comprobar si una varible existe o no esta vacia
 * @param            object            $variable            variable que se desea comprbar
 * @param            object            $tipo                tipo de varible (int - string)
 * @return            object                                variable
 * @date    Nov 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function existe(&$variable, $tipo=null)
{
    if (! empty($variable)) {

        return $variable;

    } else {

        return ( $tipo == 'int' ? 0 : ( $tipo == 'null' ? NULL : '' ) );

    }
}


/**
 * Funcion que permite convertir una variale en mayuscula, segun configuracion del cliente
 * @param  [type] $cliente_id [identificador del cliente]
 * @param  [type] &$variable  [variable]
 * @return [type]             [variable en mayuscula o como esta registrada]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mayuscula(&$variable)
{
    $variable = existe($variable);
    return (labelMayusculaSistema(session('plataforma.user.cliente.id')) ? mb_strtoupper($variable, 'UTF-8') : $variable);
}



/**
 * Funcion que permite convertir una variale en mayuscula, segun configuracion del cliente
 * @param  [type] $cliente_id [identificador del cliente]
 * @param  [type] &$variable  [variable]
 * @return [type]             [variable en mayuscula o como esta registrada]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function primeraMayuscula(&$variable)
{
    $variable = existe($variable);
    return ($variable ? mb_convert_case($variable, MB_CASE_TITLE, 'UTF-8') : $variable);
}

/**
 * Funcion que permite convertir un texto en mayuscula, segun configuracion del cliente
 * @param  [type] $cliente_id [identificador del cliente]
 * @param  [type] &$variable  [variable]
 * @return [type]             [variable en mayuscula o como esta registrada]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function cadenaMayuscula($texto)
{
    $texto   = existe($texto);
    return (labelMayusculaSistema(session('plataforma.user.cliente.id')) ? mb_strtoupper($texto, 'UTF-8') : $texto);
}


/**
 * Funcion que permite convertir un texto en mayuscula, segun configuracion del cliente
 * @param  [type] $cliente_id [identificador del cliente]
 * @param  [type] &$variable  [texto]
 * @return [type]             [texto en mayuscula o como esta registrada]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function textoMayuscula($cliente_id, $texto)
{
    return (labelMayusculaSistema($cliente_id) ? mb_strtoupper($texto, 'UTF-8') : $texto);
}


/**
 * Funcion que permite separar el identificador telefonico, del numero telefonico, para su visualizacion
 * @param  [type] $telfono [numero telefonico]
 * @@date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function visualTelefono(&$telfono = null)
{
    $telfono = existe($telfono);

    if($telfono) {

        $telefono_partes =  mb_split('[|]', $telfono);
        $ultimos_numeros = substr($telefono_partes[1], -4);
        $primeros_numeros = str_replace($ultimos_numeros, '', $telefono_partes[1]);
        return (count($telefono_partes) > 1 ? sprintf('( +56 ) %d %d %d',$telefono_partes[0],$primeros_numeros, $ultimos_numeros) : $telfono);

    }

    return false;
}

function visualTelefono2(&$telfono = null)
{
    $telfono = existe($telfono);

    if($telfono) {

        $telefono_partes =  mb_split('[|]', $telfono);
        return (count($telefono_partes) > 1 ? sprintf('%d %d',$telefono_partes[0],$telefono_partes[1]) : $telfono);

    }

    return false;
}


/**
 * Funcion que permite separar el identificador telefonico, del numero telefonico, para su visualizacion.
 * Esta funcion muestra Null o vacio, cuando la varibale no existe
 * @param  [type] $telfono [numero telefonico]
 * @@date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function visualTelefonoNoNull($telfono = null)
{
    $telfono = existe($telfono);

    if($telfono) {

        $telefono_partes =  mb_split('[|]', $telfono);
        return (count($telefono_partes) > 1 ? sprintf('( +56 ) %d %d',$telefono_partes[0],$telefono_partes[1]) : $telfono);

    }

    return false;
}


/**
 * Funcion que retorna el numero del telefono sin su numero identificados
 * @param  [type] $telfono [numero telefonico]
 * @@date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function visualNumeroTel(&$telfono = null, $tipo = null)
{
    $telfono = existe($telfono);

    if($telfono) {

        $telefono_partes =  mb_split('[|]', $telfono);
        return (count($telefono_partes) > 1 ? $telefono_partes[$tipo] : $telfono);

    }

    return false;
}



/**
 * Funcion que retorna el numero del telefono sin su numero identificados
 * @param  [type] $telfono [numero telefonico]
 * @@date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function visualNumeroTelTipo($telfono = null, $tipo = null)
{
    $telfono = existe($telfono);

    if($telfono) {

        $telefono_partes =  mb_split('[|]', $telfono);
        return (count($telefono_partes) > 1 ? $telefono_partes[$tipo] : $telfono);

    }

    return false;
}


/**
 * Funcion que permite truncar un cadena a una determinada cantidad de caracteres
 * @param  [type]  $text  [cadena]
 * @param  integer $chars [cantidad de caracteres]
 * @return [type]         [Cadena]
 * @date    Nov 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function truncate($text, $chars = 25)
{
    $text_origin =  $text;
    $text = $text." ";
    $text = mb_substr($text,0,$chars);
    $text = mb_substr($text,0,mb_strrpos($text,' '));

    if(mb_strlen($text_origin) > $chars) {

        $text = $text." ...";

    }

    return $text;
}

/**
 * Funcion que permite validar si una contraseña cumple con los minimos requerimientos
 * minimos, tales como:
 * - Minimo una mayuscula
 * - Minimo una minuscula
 * - Minimo un digito
 * - Minimo de 8 caracteres
 * @param  [type] $contrasena [contraseña a validar]
 * @return [type]             [true/false]
 * @date    Nov 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function validarSeguridadContrasena($contrasena = null)
{
    if($contrasena) {

        $validacion  = "/(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/";

        if (preg_match($validacion, $contrasena)) {

            return true;

        }
    }

    return false;
}

/**
 * Funcion que permite encriptar una palabra o cadena de texto
 * @param  [type] $data [palabra o cada de texto]
 * @param  [type] $key  [codigo de seguridad]
 *  @date    Nov 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function encriptarInformacion($data, $key)
{
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}


/**
 * Funcion que permite desencriptar una palabra o cadena de texto
 * @param  [type] $data [palabra o cada de texto]
 * @param  [type] $key  [codigo de seguridad]
 *  @date    Nov 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function desencriptarInformacion($data, $key)
{
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    $descriptar = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return $descriptar;
}


/**
 * Funcion que permite dar formato Rut Chileno xx.xxx.xxx-x
 * @param  [type] $rut [numero rut]
 *  @date Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function formatoRut($rut)
{
    if($rut) {

        $rut =  mb_ereg_replace("[\|\,\.\-]","",$rut);
        return number_format( mb_substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . mb_substr ( $rut, mb_strlen($rut) -1 , 1 );

    }

    return $rut;

}


/**
 * Funcion que pemite asignar la clase css de active para un elemento determinado
 *  @date Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function activeMenu($item=false,$item_menu=false)
{
    if($item && $item_menu) {

        return ( $item == $item_menu ? true : false);

    }

    return false;
}


/**
 * La función verifica si existen las primeras variables del servidor y según el resultado nos devuelve el valor del IP.
 *  @date Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}


/**
 * Funcion que permite validar si algun campo declarado como obligatorio, esta vacio
 * @param  array  $campos [arreglo con los campos obligatorios]
 * @return [boolean]         [true / false]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function camposObligatorios($campos = array())
{
    $response = true;

    if(!empty($campos)) {

        foreach ($campos as $key => $value) {

           if($value == '') {

             $response = false;

           }
        }
    }

    return $response;
}


/**
 * Funcion que permite validar si algun campo telefonico cumple con las validacones minimas
 * @param  array  $campos [arreglo con los campos obligatorios]
 * @return [boolean]         [true / false]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function validarCampoTelefonico($campos = array())
{
    $response = true;

    if(!empty($campos)) {

        foreach($campos as $key => $value) {

          // if ( mb_mb_strlen ($value) != 8 || ! is_numeric($value)){
           if(! is_numeric($value)) {

             $response = false;

           }
        }
    }

    return $response;
}


/**
 * Funcion que permite comparar los valores de 2 array
 * @param  array   $array_matriz_1 [array principal]
 * @param  array   $array_matriz_2 [array secundario]
 * @param  boolean $index          [array con key para comparar]
 *  @date  Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function compararArray($array_matriz_1 = array(), $array_matriz_2 = array(), $index = false)
{
    $response = array();
    $response['diff'] = false;
    $response['elemento_diff'] = array();

    if(! empty($array_matriz_1) && !empty($array_matriz_2)) {

        foreach($array_matriz_2 as $item ) {

            if(! in_array($item, $array_matriz_1)) {

                array_push($response['elemento_diff'], $item);
                $response['diff'] = true;

            }
        }

        return $response;

    } else if(empty($array_matriz_1) && !empty($array_matriz_2)) {

        foreach($array_matriz_2 as $item) {

            array_push($response['elemento_diff'], $item);
            $response['diff'] = true;

        }

        return $response;
    }

    return false;
}


/**
 * funcion que Convierta una matriz multidimensional en una matriz unidimensional.
 *  @date  Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function array_flatten($array)
{
  if(!is_array($array)) {

    return FALSE;

  }

  $result = array();

  foreach($array as $key => $value) {

    if(is_array($value)) {

      $result = array_merge($result, array_flatten($value));

    }
    else {

      $result[$key] = $value;

    }
  }

  return $result;
}


/**
 * Funcion que generar una cadena alfanumerica
 * @param  integer $length [cantidad de caracteres]
 *  @date  Mar 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function generateRandomString($length = 10)
{
    $characters = '123456789abcdefghijklmnpqrstuvwxyz';
    $charactersLength = mb_strlen($characters);
    $randomString = '';

    for($i = 0; $i < $length; $i++) {

        $randomString .= $characters[rand(0, $charactersLength - 1)];

    }

    return $randomString;
}


/**
 * Funcion que permite obtener el nombre o descripcion de la tabla estados, dependiendo su id
 * @param  [type] $estado_id [ID]
 *  @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function nombreEstado($estado_id)
{
    $nombre =  Estado::where('estados.id', $estado_id)->get(['descripcion'])->first()->toArray();
    return $nombre['descripcion'];
}


/**
 * Funcion que retorna la clase que le permite dar el estilo a los label Badge
 * @param  integer $estado [estado_id]
 * @date    Ene 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function claseLabelEstados($estado = 1)
{
    $labelEstado = array(
        '-1' =>  'badge-danger',
        '0' =>  'badge-primary',
        '1' =>  'badge-success'
    );

    return $labelEstado[$estado];
}


/**
 * Funcion que permite eliminar los saltos de linea en aquellas cadenas que se necesita, como tambien realizar
 * el truncate, si este es indicado
 * @param  boolean $cadena   [cadena]
 * @param  boolean $trucante [numero del truncate]
 * @date Agosto 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function quitarSaltoLinea($cadena = false, $trucante = false, $mayuscula = true)
{
    if ($cadena) {

        $cadena = preg_replace("/[\r\n|\n|\r]+/", " ", $cadena);

        if ($trucante > 0 ){
            $cadena = truncate($cadena, $trucante);
        }

        if ($mayuscula){
            return mayuscula($cadena);
        } else {
            return $cadena;
        }
        

    }
    return $cadena;
}

function quitarSaltoLineaSummerNote($cadena = false, $trucante = false, $mayuscula = true)
{
    if ($cadena) {

        $cadena = preg_replace("/[\r\n|\n|\r]+/", "", $cadena);

        if ($trucante > 0 ){
            $cadena = truncate($cadena, $trucante);
        }

        if ($mayuscula){
            return mayuscula($cadena);
        } else {
            return $cadena;
        }
        

    }
    return $cadena;
}


/**
 * Funcion que permite obtener el listado de las opciones de acciones,
 * para el filtro de acciones del historial
 * @return [type] [description]
 * @date Septiembre 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */
function datosBooleanos($dato, $mayuscula = true)
{
    if ($mayuscula) {
        $booleano = array("1" => "SI", "0" => "NO");
    } else {
        $booleano = array("1" => "Si", "0" => "No");   
    }

    return $booleano[$dato];
}





/**
 * Funcion que permite obtener la clase del estado de usuario en la grilla,
 * para el filtro de acciones del historial
 * @return [type] [description]
 * @date Septiembre 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */
function classEstadoUser($dato)
{
    $estado = array("0" => "primary", "1" => "success", "2" => 'secondary');

    return $estado[$dato];
}







/**
 * Funcion que pdevuelve los meses del año
 * @return [type] [description]
 * @date Septiembre 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */
function arrayMeses()
{
    $meses = [
        "01" => "Enero", 
        "02" => "Febrero", 
        "03" => 'Marzo', 
        "04" => 'Abril', 
        "05" => 'Mayo', 
        "06" => 'Junio', 
        "07" => 'Julio', 
        "08" => 'Agosto', 
        "09" => 'Septiembre', 
        "10" => 'Octubre', 
        "11" => 'Noviembre', 
        "12" => 'Diciembre'
    ];

    return $meses;
}


/**
 * Funcion que pdevuelve los meses del año
 * @return [type] [description]
 * @date Septiembre 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */
function diasSemana()
{
    $dias = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];

    return $dias;
}

function verMeses($inicio, $fin){
    $period = CarbonPeriod::create($inicio, $fin);
    $meses = arrayMeses();
    $array_meses = [];
    // Iterate over the period
    if ($inicio && $fin) {
        foreach ($period as $date) {
            $mes = [
                'id' => $date->format('Y') . '-' .$date->format('m') ,
                'descripcion' => $meses[$date->format('m')] . ' ' . $date->format('Y')
            ];
            if ( ! in_array($mes, $array_meses) )
            { 
                array_push($array_meses, $mes);
            }
        }
    }
    return $array_meses;
}

function extensionArchivos ( $dato ) {


    $tipo_residente = [
            'image/gif' => "gif",
            'image/jpeg' => "jpg",
            'image/png' => "png",
            'application/x-shockwave-flash' => "swf",
            'image/psd' => "psd",
            'image/bmp' => "bmp",
            'image/tiff' => "tiff",
            'image/tiff' => "tiff",
            'application/octet-stream' => "jpc",
            'image/jp2' => "jp2",
            'application/octet-stream' => "jpx",
            'application/octet-stream' => "jb2",
            'application/x-shockwave-flash' => "swc",
            'image/iff' => "iff",
            'image/vnd.wap.wbmp' => "wbmp",
            'image/xbm' => "xbm",
            'image/vnd.microsoft.icon' => "ico"
        ];

    return $tipo_residente[$dato];

}

function limpiarXSS($input) {
    // permitir solo algunas etiquetas HTML seguras
    $allowedTags = '<p><br><strong><em><u><hr><h1><h2><h3><h4><h5><h6><a><span><li><ul><ol><div><img>';
    $cleanInput = strip_tags($input, $allowedTags);

    // eliminar todos los caracteres de escape, como &lt; y &gt;
    // $cleanInput = htmlspecialchars($cleanInput);

    // eliminar todos los caracteres de nueva línea y tabulación
    $cleanInput = str_replace(array("\r", "\n", "\t"), '', $cleanInput);

    // eliminar los atributos que activan JavaScript de las etiquetas HTML
    $cleanInput = preg_replace('#(<[^>]+[\x00-\x20\"\'\/])(on|xmlns)[^>]*>#iU', "$1>", $cleanInput);

    // devolver la entrada limpia
    return $cleanInput;
}

function limpiarComillas($datos) {

    $reemplazo = str_replace("'", "", $datos);
    return $reemplazo;
}

function limpiarEmailEnvio($email = '') {

    $correo = $email;
    $correo = str_replace('@', '<span>@</span>', $correo);
    $correo = str_replace('.', '<span>.</span>', $correo);

    return $correo;
}

function svgIconos( $icono = "ver" ) {
    
    switch ($icono) {
        case "ver-mas":
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-blue-500"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /> </svg>';
        break;
        case "ver":
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer hover:stroke-2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>';
        break;
        case "editar":
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer hover:text-green-500 hover:stroke-2 cursor-pointer"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>';
        break;
        case "borrar":
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 pb-0 cursor-pointer hover:text-red-500 hover:stroke-1 cursor-pointer"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>';
        break;
        case "llave":
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer  hover:text-orange-500"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>';
        break;
        default:
            return '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-blue-500"> <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" /> </svg>';

    }
}

/**
 * Funcion que permite mostrar los label/etiqueta globales de la plataforma
 * @param  [type] $label      [label/etiqueta que se desea consultar]
 * @date  Abril 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function labelsPlataforma($label)
{
	$response =	[
		'CORREO_APLICACION' => 'soporte@zonanube.cl',
		'TELEFONO_APLICACION_LINK' => '+56228935609',
		'TELEFONO_APLICACION_VISUAL' => '(+562) 2 893 56 09 ',
		'URL_LOGIN_APLICACION' => route('login')
	];

	return $response[$label];
}
/**
 * Funcion que contiene el arreglo con los clientes que deben mostrar la información en mayuscula
 * @param  [type] $cliente_id [id del cliente]
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function labelMayusculaSistema($cliente_id = false, $js = false)
{
	$mayuscula = [
		''				=>	0, // Cliente default
		'1'				=>	1, // Cliente Desarrollo ZonaNube
		'386'			=>	1, // Cliente KAUFMANN
		'389'			=>	0 // Cliente Testing ZonaNube
	];

	return ( ! $js ? $mayuscula[$cliente_id] : $mayuscula );
}

