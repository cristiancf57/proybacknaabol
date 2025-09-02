<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rol=new Rol();
        $rol->cargo = $request->cargo;
        $rol->abrebiado = $request->abrebiado;
        $rol->area = $request->area;
        $rol->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rol = Rol::find($id);
        // $rol = Rol::where('cargo', 'like', '%ar%')->get();
        return view('rol.mostrar',['mascota' => $rol]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rol = Rol::find($id);
        return view('rol.edit',['rol'=>$rol]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rol = Rol::find($id);
        $rol->cargo = $request->cargo;
        $rol->abrebiado = $request->abrebiado;
        $rol->area = $request->area;
        $rol->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Rol::find($id);
        $rol->delete();
    }
}
