<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repuestos = Repuesto::all();
        if ($repuestos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($repuestos);
        // return view('repuestos.index',['repuestos'=>$repuestos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('repuestos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'nombre' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
            'stock' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $repuesto = Repuesto::create([
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock
        ]);

        if (!$repuesto){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'repuesto' => $repuesto,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $repuesto = Repuesto::find($id);
        return response()->json($repuesto);
        // return view('repuestos.mostrar', ['repuesto'=>$repuesto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $repuesto = Repuesto::find($id);
        return response()->json($repuesto);
        // return view('repuesto.edit', ['repuesto'=>$repuesto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $repuesto = Repuesto::find($id);
        if (!$repuesto) {
            $data = [
                'message' => 'accesorio no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'nombre' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
            'stock' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $repuesto->nombre = $request->nombre;
        $repuesto->marca = $request->marca;
        $repuesto->modelo = $request->modelo;
        $repuesto->descripcion = $request->descripcion;
        $repuesto->stock = $request->stock;
        $repuesto->save();

        $data = [
            'message'=> 'repuesto actualizado',
            'repuesto' => $repuesto,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $repuesto = Repuesto::find($id);
        if (!$repuesto) {
            $data = [
                'message' => 'repuesto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $repuesto->delete();
        $data = [
            'message' => 'repuesto eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
