<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\MovimientoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['role:admin'])->group(function () {
    Route::get('/articulos', [ArticuloController::class, 'index'])->name('articulos.index'); // Listar artículos
    Route::get('/articulos/crear', [ArticuloController::class, 'create'])->name('articulos.create'); // Formulario de creación
    Route::post('/articulos', [ArticuloController::class, 'store'])->name('articulos.store'); // Guardar artículo
    Route::get('/articulos/{articulo}/editar', [ArticuloController::class, 'edit'])->name('articulos.edit'); // Formulario de edición
    Route::put('/articulos/{articulo}', [ArticuloController::class, 'update'])->name('articulos.update'); // Actualizar artículo
    Route::delete('/articulos/{articulo}', [ArticuloController::class, 'destroy'])->name('articulos.destroy'); // Eliminar artículo
    

    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index'); // Listar movimientos
Route::get('/movimientos/crear', [MovimientoController::class, 'create'])->name('movimientos.create'); // Formulario de nuevo movimiento
Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimientos.store'); // Guardar movimiento
Route::get('/movimientos/{movimiento}/editar', [MovimientoController::class, 'edit'])->name('movimientos.edit'); // Formulario de edición
Route::put('/movimientos/{movimiento}', [MovimientoController::class, 'update'])->name('movimientos.update'); // Actualizar movimiento
Route::delete('/movimientos/{movimiento}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy'); // Eliminar movimiento
});

Route::middleware(['role:user'])->group(function () {
    
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
