<?php

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// Route::get('/', function () {

//     $reportes = Reporte::all();
    
//     return view('welcome',['reportes'=>$reportes]);
// });

Route::get('/usuarios', [UsuarioController::class, 'index']);
// Route::get('/usuarios', [UsuarioController::class, 'swow']);

// Route::controller(UsuarioController::class)->group(function (){
//     Route::get('/usuarios', 'index');
//     // Route::get('/usuarios', 'store');
//     // Route::get('/usuarios/{$id}', 'show');
//     // Route::get('/usuarios/{$id}', 'update');
//     // Route::get('/usuarios/{$id}', 'destroy');
// });


Route::get('/reportes', [UsuarioController::class, 'index']);