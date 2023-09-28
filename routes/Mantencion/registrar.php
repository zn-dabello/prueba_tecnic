<?php


/**
 * Archivo que contiene las rutas url (GET, POST, AJAX) del módulo de usuario
 * @date 10-08-2023
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS */
Route::group(['middleware' => ['auth', 'accesoModificarUsuario:3,5']], function () {

    Route::get('/mantencion/registrar', [App\Http\Controllers\Mantencion\RegistrarController::class, 'create']);

    Route::post('/mantencion/registrar', [App\Http\Controllers\Mantencion\RegistrarController::class, 'store'])->name('mantencion/registrar');

    Route::post('/mantencion/registrar/borrar', [App\Http\Controllers\Mantencion\RegistrarController::class, 'destroy']);

    Route::patch('/mantencion/registrar/editar', [App\Http\Controllers\Mantencion\RegistrarController::class, 'update'])->name('mantencion/registrar/editar');

});

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS + VISUALIZADORES */
Route::group(['middleware' => ['auth', 'accesoUsuario:3,5']], function () {

    Route::get('/mantencion/registrarse', [App\Http\Controllers\Mantencion\RegistrarController::class, 'index'])->name('mantencion/registrarse');

    Route::post('/mantencion/ajax-request-registrarse', [App\Http\Controllers\Mantencion\RegistrarController::class, 'grid']);

    Route::get('/mantencion/registrar/{tipo}/{id}', [App\Http\Controllers\Mantencion\RegistrarController::class, 'show']);

    /** POST */
    Route::post('/mi-institucion/exportar-excel-direcciones', [App\Http\Controllers\Mantencion\RegistrarController::class, 'exportxlsx'])->name('mi-institucion/exportar-excel-direcciones');

});
