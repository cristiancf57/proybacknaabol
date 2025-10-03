<?php

namespace App\Http\Controllers;

use App\Models\Designacion;
use Illuminate\Http\Request;

class DesignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designacion = Designacion::all();
        if ($designacion->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($designacion);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deignaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = validator($request->all(),[
            'estado' => 'required',
            'usuario_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad = Designacion::create([
            'estado' => $request->estado,
            'fecha_inicio'=>$request->fecha_inicio,
            'usuario_id' => $request->usuario_id,
            'cargo_id' => $request->cargo_id
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
        $designacion = Designacion::find($id);
         return response()->json($designacion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $designacion = Designacion::find($id);
        return response()->json($designacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'designacion no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'estado' => 'required',
            'usuario_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $designacion->estado = $request->estado;
        $designacion->fecha_inicio = $request->fecha_inicio;
        $designacion->fecha_fin = $request->fecha_fin;
        $designacion->usuario_id = $request->usuario_id;
        $designacion->cargo_id = $request->cargo_id;
        $designacion->save();

        $data = [
            'message'=> 'designaicion actualizado',
            'designaicion' => $designacion,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
    * Update the specified resource in storage.
    */
    public function updatePartial(Request $request, string $id) {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'designacion no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('estado')){
            $designacion->estado = $request->estado;
        }

        if ($request->has('fecha_inicio')){
            $designacion->fecha_inicio = $request->fecha_inicio;
        }
        
        if ($request->has('fecha_fin')){
            $designacion->fecha_fin = $request->fecha_fin;
        }
        
        if ($request->has('usuario_id')){
            $designacion->usuario_id = $request->usuario_id;
        }
        
        if ($request->has('cargo_id')){
            $designacion->cargo_id = $request->cargo_id;
        }
        
        $designacion->save();

        $data = [
            'message'=> 'desi$designacion actualizado',
            'desi$designacion' => $designacion,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'dato no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $designacion->delete();

        $data = [
            'message' => 'designacion eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
