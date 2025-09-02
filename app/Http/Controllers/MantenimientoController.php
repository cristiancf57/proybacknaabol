<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mantenimientos = Mantenimiento::all();
        return view('mantenimiento.index', ['mantenimientos'=>$mantenimientos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mantenimiento.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mantenimiento = new Mantenimiento();
        $mantenimiento->fecha_programada = $request->fecha_programada;
        $mantenimiento->fecha_realizada = $request->fecha_realizada;
        $mantenimiento->tipo_mantenimiento = $request->tipo_mantenimiento;
        $mantenimiento->resultados = $request->resultados;
        $mantenimiento->foto_antes = $request->foto_antes;
        $mantenimiento->foto_despues = $request->foto_despues;
        $mantenimiento->observaciones = $request->observaciones;
        $mantenimiento->activo_id = $request->activo_id;
        $mantenimiento->tecnico_id = $request->tecnico_id;
        $mantenimiento->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        return view('mantenimiento.mostrar', ['mantenimiento'=>$mantenimiento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        return view('mantenimiento.edit', ['Mantenimiento'=>$mantenimiento]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento->fecha_programada = $request->fecha_programada;
        $mantenimiento->fecha_realizada = $request->fecha_realizada;
        $mantenimiento->tipo_mantenimiento = $request->tipo_mantenimiento;
        $mantenimiento->resultados = $request->resultados;
        $mantenimiento->foto_antes = $request->foto_antes;
        $mantenimiento->foto_despues = $request->foto_despues;
        $mantenimiento->observaciones = $request->observaciones;
        $mantenimiento->activo_id = $request->activo_id;
        $mantenimiento->tecnico_id = $request->tecnico_id;
        $mantenimiento->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento->delete();
    }
}
