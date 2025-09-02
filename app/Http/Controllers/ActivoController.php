<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activos = Activo::all();
        return view('activos.intex', ['activos'=>$activos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $activo = new Activo();
        $activo->detalle = $request->detalle;
        $activo->activo = $request->activo;
        $activo->marca = $request->marca;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->color = $request->color;
        $activo->area = $request->area;
        $activo->ip = $request->ip;
        $activo->ubicacion = $request->ubicacion;
        $activo->estado = $request->estado;
        $activo->descripcion = $request->descripcion;
        $activo->tipo_id = $request->tipo_id;
        $activo->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activo = Activo::find($id);
        return view('activos.mostrar', ['activo'=>$activo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activo = Activo::find($id);
        return view('activos.edit', ['activo'=>$activo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activo = Activo::find($id);
        $activo->detalle = $request->detalle;
        $activo->activo = $request->activo;
        $activo->marca = $request->marca;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->color = $request->color;
        $activo->area = $request->area;
        $activo->ip = $request->ip;
        $activo->ubicacion = $request->ubicacion;
        $activo->estado = $request->estado;
        $activo->descripcion = $request->descripcion;
        $activo->tipo_id = $request->tipo_id;
        $activo->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activo = Activo::find($id);
        $activo->delete();
    }
}
