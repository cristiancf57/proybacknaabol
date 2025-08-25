<?php

use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $usuario = new Usuario();
    
    return view('welcome');
});
