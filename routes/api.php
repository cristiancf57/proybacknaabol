<?php

use App\Http\Controllers\Api\ActareporteController;
use App\Http\Controllers\Api\ActivoController;
use App\Http\Controllers\Api\ActividadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComponenteController;
use App\Http\Controllers\Api\MantenimientoController;
use App\Http\Controllers\Api\RepuestoController;
use App\Http\Controllers\Api\TareaController;
use App\Http\Controllers\Api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Usuarios - Solo admin puede gestionar
    Route::middleware(['role:admin|administrador', 'permission:manage users'])->controller(UsuarioController::class)->group(function (){
        Route::get('/usuarios', 'index');
        Route::post('/usuarios', 'store');
        Route::get('/usuarios/{id}', 'show');
        Route::put('/usuarios/{id}', 'update');
        Route::patch('/usuarios/{id}', 'updatePartial');
        Route::delete('/usuarios/{id}', 'destroy');
    });

    // Activos - Diferentes niveles de acceso
    Route::controller(ActivoController::class)->group(function (){
        // Ver activos - Múltiples roles pueden ver
        Route::get('/activos', 'index')->middleware('role:admin|manager|user');
        Route::get('/activos/{id}', 'show')->middleware('role:admin|manager|user');
        Route::get('/activoscd/{codigo}', 'codig')->middleware('role:admin|manager|user');
        Route::get('/estadisticas', 'getEstadisticas')->middleware('role:admin|manager|user');

        
        // Crear y editar - Solo admin y manager
        Route::post('/activos', 'store')->middleware('role:admin|manager');
        Route::put('/activos/{id}', 'update')->middleware('role:admin|manager');
        Route::patch('/activos/{id}', 'updatePartial')->middleware('role:admin|manager');
        
        // Eliminar - Solo admin
        Route::delete('/activos/{id}', 'destroy')->middleware('role:admin');
        
        // Estadísticas - Solo admin y manager
        // Route::get('/estadisticas', 'getEstadisticas')->middleware('role:admin|manager');
    });
});

// controladores de actividades
Route::controller(ActividadController::class)->group(function (){
    Route::get('/actividad', 'index');
    Route::get('/actividades', 'detalle');
    Route::post('/actividades', 'store');
    Route::get('/actividades/{id}', 'show');
    Route::put('/actividades/{id}', 'update');
    Route::patch('/actividades/{id}', 'updatePartial');
    Route::delete('/actividades/{id}', 'destroy');
});

// controladores de reportes
Route::controller(TareaController::class)->group(function (){
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
    Route::get('/mantenimientod', 'detalle');
    Route::get('/mantenimientoc', 'calendar');
    Route::post('/mantenimientos', 'store');
    Route::get('/mantenimientos/{id}', 'show');
    Route::get('/mantenimientoac/{id}', 'activ');
    Route::put('/mantenimientos/{id}', 'update');
    Route::patch('/mantenimientos/{id}', 'updatePartial');
    Route::delete('/mantenimientos/{id}', 'destroy');
});

// controladores de actas
Route::controller(ActareporteController::class)->group(function (){
    Route::get('/actareportes', 'index');
    Route::post('/actareportes', 'store');
    Route::get('/actareportes/{id}', 'show');
    Route::put('/actareportes/{id}', 'update');
    Route::patch('/actareportes/{id}', 'updatePartial');
    Route::delete('/actareportes/{id}', 'destroy');
});

// controladores de repuestos o accesorios
Route::controller(RepuestoController::class)->group(function (){
    Route::get('/repuestos', 'index');
    Route::get('/repuestosdis', 'disponibles');
    Route::post('/repuestos', 'store');
    Route::get('/repuestos/{id}', 'show');
    Route::put('/repuestos/{id}', 'update');
    Route::patch('/repuestos/{id}', 'updateStock');
    Route::delete('/repuestos/{id}', 'destroy');
});
// controladores de componentes
Route::controller(ComponenteController::class)->group(function (){
    Route::get('/componentes', 'index');
    Route::post('/componentes', 'store');
    Route::get('/componentes/{id}', 'show');
    Route::get('/componenteas/{id}', 'asignados');
    Route::put('/componentes/{id}', 'update');
    Route::patch('/componentes/{id}', 'updatePartial');
    Route::delete('/componentes/{id}', 'destroy');
});