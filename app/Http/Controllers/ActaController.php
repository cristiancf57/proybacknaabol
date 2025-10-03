<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actas = Acta::all();
        if ($actas->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($actas);
        // return response()->json($actas,200);
        // return view('actas.index',['actas'=>$actas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'descripcion' => 'required',
            'actividad_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $acta = Acta::create([
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),  // "2025-08-29"
            'descripcion' => $request->descripcion,
            'encargado' => $request->encargado,
            'tecnico' => $request->tecnico,
            'supervisor' => $request->supervisor,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
            'actividad_id' => $request->actividad_id
        ]);

        if (!$acta){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'usuario' => $acta,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $acta = Acta::find($id);
        return view('actas.mostrar', ['acta'=>$acta]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acta =Acta::find($id);
        return view('actas.edit', ['acta'=>$acta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        $validator = validator($request->all(),[
            'descripcion' => 'required',
            'actividad_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        
        $acta->descripcion =  Carbon::now('America/La_Paz')->toDateString();  // "2025-08-29"
        $acta->descripcion = $request->descripcion;
        $acta->encargado = $request->encargado;
        $acta->tecnico = $request->tecnico;
        $acta->supervisor = $request->supervisor;
        $acta->estado = $request->estado;
        $acta->observaciones = $request->observaciones;
        $acta->actividad_id = $request->actividad_id;
        $acta->save();

        $data = [
            'message'=> 'acta actualizado',
            'acta' => $acta,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $acta = Acta::find($id);
        if (!$acta) {
            $data = [
                'message' => 'acta no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('fecha')){
            $acta->fecha = $request->fecha;
        }
        
        if ($request->has('descripcion')){
            $acta->descripcion = $request->descripcion;
        }
        
        if ($request->has('encargado')){
            $acta->encargado = $request->encargado;
        }
        
        if ($request->has('tecnico')){
            $acta->tecnico = $request->tecnico;
        }
        
        if ($request->has('estado')){
            $acta->estado = $request->estado;
        }
        
        if ($request->has('supervisor')){
            $acta->supervisor = $request->supervisor;
        }

        if ($request->has('observaciones')){
            $acta->observaciones = $request->observaciones;
        }
        
        if ($request->has('actividad_id')){
            $acta->actividad_id = $request->actividad_id;
        }
        
        $acta->save();

        $data = [
            'message'=> 'Acta actualizado',
            'acta' => $acta,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $acta = Acta::find($id);
        if (!$acta) {
            $data = [
                'message' => 'acta no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $acta->delete();

        $data = [
            'message' => 'acta eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
