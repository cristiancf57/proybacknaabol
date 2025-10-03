<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\Api\ActividadController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// controladores de usuario
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::patch('/usuarios/{id}', [UsuarioController::class, 'updatePartial']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

// controladores de reportes
Route::get('/reportes', [ReporteController::class, 'index']);
Route::get('/reportes/{id}', [ReporteController::class, 'show']);
Route::post('/reportes', [UsuarioController::class, 'store']);
Route::put('/reportes/{id}', [UsuarioController::class, 'update']);
Route::patch('/reportes/{id}', [UsuarioController::class, 'updatePartial']);
Route::delete('/reportes/{id}', [UsuarioController::class, 'destroy']);

// controladores de actas
Route::get('/actas', [ActaController::class, 'index']);
Route::get('/actas/{id}', [ActaController::class, 'show']);
Route::post('/actas', [ActaController::class, 'store']);
Route::put('/actas/{id}', [UsuarioController::class, 'update']);
Route::patch('/actas/{id}', [UsuarioController::class, 'updatePartial']);
Route::delete('/actas/{id}', [UsuarioController::class, 'destroy']);

// controladores de mantenimientos
Route::get('/mantenimientos', [MantenimientoController::class, 'index']);
Route::get('/mantenimientos/{id}', [MantenimientoController::class, 'show']);
Route::post('/mantenimientos', [MantenimientoController::class, 'store']);
Route::put('/mantenimientos/{id}', [UsuarioController::class, 'update']);
Route::patch('/mantenimientos/{id}', [UsuarioController::class, 'updatePartial']);
Route::delete('/mantenimientos/{id}', [UsuarioController::class, 'destroy']);

// controladores de activos
Route::get('/activos', [ActivoController::class, 'index']);
Route::get('/activos/{id}', [ActivoController::class, 'show']);
Route::post('/activos', [ActivoController::class, 'store']);
Route::put('/activos/{id}', [UsuarioController::class, 'update']);
Route::patch('/activos/{id}', [UsuarioController::class, 'updatePartial']);
Route::delete('/activos/{id}', [UsuarioController::class, 'destroy']);

// controladores de actividades
Route::controller(ActividadController::class)->group(function (){
    Route::get('/actividades', 'index');
    Route::post('/actividades', 'store');
    Route::get('/actividades/{id}', 'show');
    Route::put('/actividades/{id}', 'update');
    Route::patch('/actividades/{id}', 'updatePartial');
    Route::delete('/actividades/{id}', 'destroy');
});