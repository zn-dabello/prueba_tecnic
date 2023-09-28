<?php


/**
 * Archivo que contiene las rutas url (GET, POST, AJAX) del módulo de sub-direcciones
 * @date 22-08-2023
 * @copyright ZonaNube (zonanube.cl)
 * @author Raudely Pimentel <rpimentel@zonanube.com>
 */

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS */
Route::group(['middleware' => ['auth', 'accesoModificarUsuario:3,6']], function () {

    Route::get('/mi-institucion/sub-direccion', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'create']);

    Route::post('/mi-institucion/sub-direccion', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'store'])->name('mi-institucion/sub-direccion');

    Route::post('/mi-institucion/sub-direccion/borrar', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'destroy']);

    Route::patch('/mi-institucion/sub-direccion/editar', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'update'])->name('mi-institucion/sub-direccion/editar');

});

/** GRUPO ROUTING VALIDACION DE PERFILES AUTORIZADOS + VISUALIZADORES */
Route::group(['middleware' => ['auth', 'accesoUsuario:3,6']], function () {

    Route::get('/mi-institucion/sub-direcciones', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'index'])->name('mi-institucion/sub-direcciones');

    Route::post('/mi-institucion/ajax-request-sub-direcciones', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'grid']);

    Route::get('/mi-institucion/sub-direcciones/{tipo}/{id}', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'show']);

    /** POST */
    Route::post('/mi-institucion/exportar-excel-sub-direcciones', [App\Http\Controllers\MiInstitucion\SubDireccionesController::class, 'exportxlsx'])->name('mi-institucion/exportar-excel-sub-direcciones');

});
