<?php

/**
 * Archivo que contendrá los mensajes de error, success, info, warning, de la plataforma
 */

/**
 * Funcion que permite un mensaje o respuesta de error segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeError($key_msn = 'errGuardar', $array = false)
{
	$response 	=	[
		'errAccion' => 'Permiso Denegado.',
		'errGuardar' => 'Error al guardar los datos. Si el problema persiste comun&iacute;quese con soporte.',
		'errBuscar' => 'Error al obtener los datos. Si el problema persiste comun&iacute;quese con soporte.',
		'errActualizar' => 'Error al modificar los datos. Si el problema persiste comun&iacute;quese con soporte.',
		'errBorrar' => 'Error al borrar los datos. Si el problema persiste comun&iacute;quese con soporte.',
		'errRestaurar' => 'Error al restaurar los datos. Si el problema persiste comun&iacute;quese con soporte.',
		'errArchivoTamanio' => 'El archivo tiene un tama&ntilde;o superior al m&aacute;ximo permitido.',
		'errArchivoFormato' => 'Formato del archivo inv&aacute;lido.',
		'errNuevaClave' => 'La nueva contrase&ntilde;a es inv&aacute;lida.',
		'errClave' => 'La contrase&ntilde;a actual es inv&aacute;lida.',
		'errDuplicado' => 'Ya existe un registro con esos datos.',
		'errEmail' => 'Ya existe un registro con ese correo electrónico, revise los datos e intente nuevamente.',
		'errUsuario' => 'Ya existe un registro con ese nombre de usuario, revise los datos e intente nuevamente.',
		'errRut' => 'Ya existe un registro con ese rut, revise los datos e intente nuevamente.',
		'errArchivo' => 'Error al guardar el documento. Si el problema persiste comun&iacute;quese con soporte.',
		'errFormatoTel' => 'Número Inválido.',
		'errConInternet' => '<b>ERROR:</b> Sin conexi&oacute;n. Revise el estado de su conexi&oacute;n a internet.',
		'errConAplicacion' => '<b>ERROR:</b> Error al conectarse a la aplicaci&oacute;n. Revise su conexi&oacute;n a internet y si el problema persiste comun&iacute;quese con soporte.'
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de warning segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeWarning($key_msn = 'default', $array = false)
{
	$response  =  [
		/** DEFAULT */
		'default' => 'Faltan datos por ingresar. Revise el formulario e intente nuevamente.',
		'default_invalid' => 'Faltan datos por ingresar. Revise el formulario e intente nuevamente.',
		'warnLoginIncorrecto' => 'Correo Electrónico y/o contraseña incorrecto, revise los datos e intente nuevamente.',
		'warnNoActualizar' => 'No hay cambios, revise los datos e intente nuevamente.',
		'warnRecaptcahIncorrecto' => 'Debe ingresar el captcha.',
		'warnRutIncorrecto' => 'Rut incorrecto, revise los datos e intente nuevamente.',
		'warnCuentaNoHabilitada' => 'Su cuenta no está habilitada.',
		'warnCuentaBloqueada1' => 'Su cuenta ha sido bloqueada, debido a que ha fallado la autentificación más de 5 veces, contacte con soporte para gestionar el desbloqueo de su cuenta.',
		'warnCuentaBloqueada2' => 'Su cuenta está bloqueada, contacte con soporte para gestionar el desbloqueo de su cuenta.',
		'warnUsuarioNoRegistrado' => 'El nombre de usuario o el correo electrónico no está registrado. Revise los datos e intente nuevamente.',
		'warnEmailNoRegistrado' => 'Correo Electrónico ingresado no está registrado, revise los datos e intente nuevamente.',
		'warnEmailRegistrado' => 'Es necesario ingresar el correo electrónico que tiene registrado para su cuenta.',
		'warnIndicaciones' => 'Es necesario cumplir con la indicaciones dadas.',
		'warnPassNoCoincide' => 'Las contraseñas ingresadas no coinciden.',
		'superarCaracteres' => 'No debe superar los caracteres indicados, revise los datos e intente nuevamente. ',
		'minCampoTel' => 'Debe ingresar un número de teléfono válido.',
		'warnOpcion' => 'Debe seleccionar al menos una opción para exportar.',
		'warnPerfil' => 'Su perfil no tiene acceso al módulo seleccionado.',
		'warnAcceso' => 'Usted no tiene acceso al módulo seleccionado.',
		'warnMaximoRegistros' =>'Ha excedido el máximo de registros.',
		'warnAuth2' =>'Este correo no tiene una cuenta de usuario asociada.',
		'warnPrincipalObligatorio' =>'Debe existir al menos una imagen principal.',
		'warnPrincipalExiste' =>'Ya existe una imagen principal.',
		'warnHabilitar' =>'No se puede habilitar el documento hasta que tenga al menos una etapa de apronción en el Flujo Documental.'
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de success segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeSuccess($key_msn = 'succGuardar', $array = false)
{
	$response =	[
		'succGuardar' => 'Se ha guardado la información.',
		'succActualizar' =>	'Se ha actualizado la información.',
		'succEliminar' => 'Se ha eliminado la información.',
		'succContratistaEspera' => 'Se ha guardado la información. Ahora debe esperar a que el Administrador General revise los datos.',
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de question segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeQuestions($key_msn = 'quesCerrar', $array = false)
{
	$response 	=	[
		'quesBorrar' =>	'¿Está seguro que desea borrar los datos seleccionados?',
		'quesDesbloquear' => '¿Está seguro que desea desbloquear al usuario seleccionados?',
		'quesCerrar' =>	'¿Está seguro que desea salir? <br> Perderá los datos que fueron modificados.',
		'quesHabilitarDoc' =>	'¿Está seguro que desea habilitar el documento? <br> Despues de habilitarlo no podrá modificar algunos datos.',
		'quesTramitarDoc' =>	'¿Está seguro que desea tramitar el documento? <br> Despues de habilitar la tramitación no podrá modificar algunos datos.',
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de info segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeInfo($key_msn = 'default', $array = false)
{
	$response =	[
		/** DEFAULT */
		'default' => 'Proceso exitoso.',
		/** LOGIN Y REGISTRO */
		'restContrasena' =>	'Su contraseña fue cambiada.',
		'envioCorreo' => 'Se ha enviado un correo electrónico con el siguiente paso para obtener su contraseña de acceso.'
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de validacion de campos segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeInput($key_msn = 'default', $array = false)
{
	$response =	[
		/** DEFAULT */
		'default' => 'Faltan datos por ingresar. Revise el formulario e intente nuevamente.',
		/** CAMPOS */
		'inputEmailValido' => 'Por favor ingrese un correo electrónico válido (ejemplo@dominio.ext).',
		'inputEmailInvalido' =>	'Correo Electrónico inválido.',
	];

	return (!$array ? $response[$key_msn] : $response);
}


/**
 * Funcion que permite un mensaje o respuesta de acciones de envio de correo segun su key (accion). Tambien puede retonar
 * todo el array con los mensajes (para Javascript)
 * @param  [type]  $key_msn [accion]
 * @param  boolean $array   [mensaje / array]
 *
 * @date    Dic 2019
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 */
function mensajeEmail($key_msn = 'default', $array = false)
{
	$response =	[
		/** DEFAULT */
		'default' => 'Correo enviado por Portal ZonaNube.',
		/** CAMPOS */
		'emailAsunto' => ' Portal ZonaNube - Solicitud de nueva contraseña de acceso',
	];

	return (!$array ? $response[$key_msn] : $response);
}
