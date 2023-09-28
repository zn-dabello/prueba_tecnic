<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

 if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR); // Asi se debe colocar el / o \ para evitar conflictos con Linux y Windows
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('login');
});

Route::group(['middleware' => ['auth']], function () {
    // Route::group(['middleware' => ['auth', 'statusUser']], function () {

    Route::get('/home', [App\Http\Controllers\Inicio\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\Inicio\HomeController::class, 'index'])->name('dashboard');


    /** ROUTING MI INSTITUCION */
    require __DIR__ . DS . 'Mantencion' . DS . 'registrar.php';

    require __DIR__ . DS . 'Mantencion' . DS . 'sub_direcciones.php';

    /** ROUTING Historial */
    require __DIR__ . DS . 'Historial' . DS . 'historial.php';

    //MENU

    Route::get('/mi-institucion/ficha', [App\Http\Controllers\Inicio\HomeController::class, 'index'])->name('mi-institucion/ficha');

    Route::get('/mi-institucion/unidades', [App\Http\Controllers\Inicio\HomeController::class, 'index'])->name('mi-institucion/unidades');

    Route::get('/minutas', [App\Http\Controllers\Inicio\HomeController::class, 'index'])->name('minutas');

});

require __DIR__.'/auth.php';
