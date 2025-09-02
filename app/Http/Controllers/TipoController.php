<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = Tipo::all();
        return view('tipo.index', ['tipos'=>$tipos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipo = new Tipo();
        $tipo->descripcion = $request->descripcoin;
        $tipo->observaciones = $request->observaciones;
        $tipo->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tipo = Tipo::find($id);
        return view('tipo.mostrar', ['tipo'=>$tipo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipo = Tipo::find($id);
        return view('tipo.edit', ['tipo'=>$tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tipo = Tipo::find($id);
        $tipo->descripcion = $request->descripcoin;
        $tipo->observaciones = $request->observaciones;
        $tipo->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tipo = Tipo::find($id);
        $tipo->delete();
    }
}
