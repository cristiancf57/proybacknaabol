<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\MantenimientoController;
use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {

    $reportes = Reporte::all();
    
    return view('welcome',['reportes'=>$reportes]);
});

// controladores de usuarios
Route::controller(UsuarioController::class)->group(function (){
    Route::get('/usuarios', 'index');
    Route::post('/usuarios', 'store');
    Route::get('/usuarios/{id}', 'show');
    Route::put('/usuarios/{id}', 'update');
    Route::patch('/usuarios/{id}', 'updatePartial');
    Route::delete('/usuarios/{id}', 'destroy');
});

// controladores de activos
Route::controller(ActivoController::class)->group(function (){
    Route::get('/activos', 'index');
    Route::post('/activos', 'store');
    Route::get('/activos/{id}', 'show');
    Route::put('/activos/{id}', 'update');
    Route::patch('/activos/{id}', 'updatePartial');
    Route::delete('/activos/{id}', 'destroy');
});

// controladores de reportes
Route::controller(ReporteController::class)->group(function (){
    Route::get('/reportes', 'index');
    Route::post('/reportes', 'store');
    Route::get('/reportes/{id}', 'show');
    Route::put('/reportes/{id}', 'update');
    Route::patch('/reportes/{id}', 'updatePartial');
    Route::delete('/reportes/{id}', 'destroy');
});

// controladores de mantenimientos
Route::controller(MantenimientoController::class)->group(function (){
    Route::get('/mantenimientos', 'index');
    Route::post('/mantenimientos', 'store');
    Route::get('/mantenimientos/{id}', 'show');
    Route::put('/mantenimientos/{id}', 'update');
    Route::patch('/mantenimientos/{id}', 'updatePartial');
    Route::delete('/mantenimientos/{id}', 'destroy');
});

// controladores de actividades
Route::controller(ActividadController::class)->group(function (){
    Route::get('/actividades', 'index');
    Route::post('/actividades', 'store');
    Route::get('/actividades/{id}', 'show');
    Route::put('/actividades/{id}', 'update');
    Route::patch('/actividades/{id}', 'updatePartial');
    Route::delete('/actividades/{id}', 'destroy');
});

Route::get('/actas', [ActaController::class, 'index']);