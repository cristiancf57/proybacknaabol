<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $roles = Cargo::all();
        $roles = Cargo::where('descripcion', '!=', 'Desarrollador')->get();
        if ($roles->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($roles);
        // return view('cargos.index', ['cargos' => $roles]);
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
        $validator = validator($request->all(),[
            'descripcion' => 'required',
            'area' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad = Cargo::create([
            'descripcion' => $request->descripcion,
            'area' => $request->area
        ]);
        
        if (!$actividad){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $actividad,
            'status' =>201
        ];
        return response()->json($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cargo = Cargo::find($id);
        // $rol = Cargo::where('cargo', 'like', '%ar%')->get();
        // return view('cargos.mostrar',['mascota' => $cargo]);
         return response()->json($cargo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargo = Cargo::find($id);
        // return view('cargos.edit',['cargo'=>$cargo]);
        return response()->json($cargo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cargo = Cargo::find($id);
        $cargo->descripcion = $request->descripcion;
        $cargo->area = $request->area;
        $cargo->save();

        $data = [
            'message'=> 'actividad actualizado',
            'cargo' => $cargo,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cargo = Cargo::find($id);
        if (!$cargo) {
            $data = [
                'message' => 'dato no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $cargo->delete();

        $data = [
            'message' => 'cargo eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
