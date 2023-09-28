<?php


/**
 * Archivo que contiene las rutas url (GET, POST, AJAX) del módulo de usuario
 * @date 22-08-2023
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS */


/// Rutas que no pasan por la validacion de acceso

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/mis-datos/clave', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'showClave']);
    
    Route::patch('/mis-datos/clave', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'updateClave'])->name('mis-datos/clave');

    Route::get('/mis-datos', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'showSesion']);
    
    Route::patch('/mis-datos', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'updateSesion'])->name('mis-datos');

});

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS + VISUALIZADORES */
Route::group(['middleware' => ['auth', 'accesoModificarUsuario:3,8']], function () {

    // Acciones
    
    Route::get('/mi-institucion/usuario', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'create']);

    Route::post('/mi-institucion/usuario', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'store'])->name('mi-institucion/usuario');

    Route::post('/mi-institucion/usuario/borrar', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'destroy']);

    Route::patch('/mi-institucion/usuario/editar', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'update'])->name('mi-institucion/usuario/editar');
    
    Route::post('/mi-institucion/usuario/editar-accesos', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'updateAccesos'])->name('mi-institucion/usuario/editar-accesos');

    Route::get('/mi-institucion/usuario/clave/{id}', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'showClaveUsuario']);
    
    Route::patch('/mi-institucion/usuario/clave', [App\Http\Controllers\MiInstitucion\MisDatosController::class, 'updateClaveUsuario'])->name('usuario/clave');
    
});

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS + VISUALIZADORES */
Route::group(['middleware' => ['auth', 'accesoUsuario:3,8']], function () {
    
    Route::get('/mi-institucion/usuarios', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'index'])->name('mi-institucion/usuarios');

    Route::post('/mi-institucion/ajax-request-usuarios', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'grid']);

    Route::get('/mi-institucion/usuario/{tipo}/{id}', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'show']);
    
    /** POST */
    Route::post('/mi-institucion/exportar-excel-usuarios', [App\Http\Controllers\MiInstitucion\UsuarioController::class, 'exportxlsx'])->name('mi-institucion/exportar-excel-usuarios');

});