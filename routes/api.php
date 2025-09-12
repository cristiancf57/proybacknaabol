<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
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

// controladores de actas
Route::get('/actas', [ActaController::class, 'index']);
Route::get('/actas/{id}', [ActaController::class, 'index']);
Route::post('/actas', [ActaController::class, 'store']);

// controladores de mantenimientos
Route::get('/mantenimientos', [MantenimientoController::class, 'index']);
Route::post('/mantenimientos', [MantenimientoController::class, 'store']);

// controladores de activos
Route::get('/activos', [ActivoController::class, 'index']);
Route::post('/activos', [ActivoController::class, 'store']);