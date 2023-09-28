<?php


/**
 * Archivo que contiene las rutas url (GET, POST, AJAX) del módulo primario Inicio
 * @date Junio 2020
 * @copyright ZonaNube (zonanube.cl)
 * @author Steven Salcedo <ssalcedo@zonanube.cl>
 * @co-author Raudely Pimentel <rpimentel@zonanube.com>
 */

/** POST */
Route::post('/ajax-buscar-historial-detalle', [App\Http\Controllers\Historial\HistorialRegistroController::class, 'ajaxRequestformHistorial']);

/** AJAX */
Route::post('/ajax-historial', [App\Http\Controllers\Historial\HistorialRegistroController::class, 'ajaxRequestHistorial']);

Route::post('/ajax-buscar-historial-detalle', [App\Http\Controllers\Historial\HistorialRegistroController::class, 'ajaxRequestHistorialDetalle']);


Route::post('/ajax-buscar-historial-detalle-listado', [App\Http\Controllers\Historial\HistorialRegistroController::class, 'ajaxRequestHistorialDetalleListado']);