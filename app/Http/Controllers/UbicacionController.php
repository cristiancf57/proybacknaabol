<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ubicaciones = Ubicacion::all();
        if ($ubicaciones->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($ubicaciones);
        // return view('ubicaciones.index', ['ubicaciones'=>$ubicaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ubicaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'lugar' => 'required',
            'detalle' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $ubicacion = Ubicacion::create([
            'lugar' => $request->lugar,
            'detalle' => $request->detalle
        ]);
        
        if (!$ubicacion){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'ubicacion' => $ubicacion,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ubicacion = Ubicacion::find($id);
        return response()->json($ubicacion);
        // return view('ubicaciones.mostrar', ['ubicacion'=>$ubicacion]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ubicacion = Ubicacion::find($id);
        return response()->json($ubicacion);
        // return view('ubicaciones.edit', ['ubicacion'=>$ubicacion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ubicacion = Ubicacion::find($id);
        if (!$ubicacion) {
            $data = [
                'message' => 'ubicacion no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'lugar' => 'required',
            'detalle' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $ubicacion->lugar = $request->lugar;
        $ubicacion->detalle = $request->detalle;
        $ubicacion->save();
        
        $data = [
            'message'=> 'actividad actualizado',
            'actividad' => $ubicacion,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ubicacion = Ubicacion::find($id);
        if (!$ubicacion) {
            $data = [
                'message' => 'ubicacion no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $ubicacion->delete();
        $data = [
            'message' => 'actividad eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
