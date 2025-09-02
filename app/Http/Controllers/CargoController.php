<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Cargo::all();
        return view('cargos.index', ['cargos' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rol=new Cargo();
        $rol->descripcion = $request->descripcion;
        $rol->abrebiado = $request->abrebiado;
        $rol->area = $request->area;
        $rol->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cargo = Cargo::find($id);
        // $rol = Rol::where('cargo', 'like', '%ar%')->get();
        return view('cargos.mostrar',['mascota' => $cargo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargo = Cargo::find($id);
        return view('cargos.edit',['cargo'=>$cargo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rol = Cargo::find($id);
        $rol->descripcion = $request->descripcion;
        $rol->abrebiado = $request->abrebiado;
        $rol->area = $request->area;
        $rol->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Cargo::find($id);
        $rol->delete();
    }
}
