<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actas = Acta::all();
        return view('acta.index',['actas'=>$actas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('acta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $acta = new Acta();
        $acta->codigo_acta = $request->codigo_acta;
        $acta->descripcion = $request->descripcion;
        $acta->encargado = $request->encargado;
        $acta->mantenimiento_id = $request->mantenimiento_id;
        $acta->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $acta = Acta::find($id);
        return view('acta.mostrar', ['acta'=>$acta]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acta =Acta::find($id);
        return view('acta.edit', ['acta'=>$acta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acta = Acta::find($id);
        $acta->codigo_acta = $request->codigo_acta;
        $acta->descripcion = $request->descripcion;
        $acta->encargado = $request->encargado;
        $acta->mantenimiento_id = $request->mantenimiento_id;
        $acta->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acta = Acta::find($id);
        $acta->delete();
    }
}
