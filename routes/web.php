<?php

use App\Models\Reporte;
use App\Models\Usuario;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // $reporte = new Reporte();
    // $reporte->detalle="lector de tarjetas de la pueta desembarque apagada";
    // $reporte->tipo_reporte="sistemas";
    // $reporte->foto="pueta_desembarque.jpg";
    // $reporte->estado="nuevo";
    // $reporte->personal="personal de aeropuerto";
    // $reporte->save();

    $reportes = Reporte::all();
    
    return view('welcome',['reportes'=>$reportes]);
});
