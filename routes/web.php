<?php

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $reportes = Reporte::all();
    
    return view('welcome',['reportes'=>$reportes]);
});

Route::get('/usuarios', function() {
    return view('index');
});