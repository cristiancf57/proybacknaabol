<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use App\Models\Repuesto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $componentes = Componente::all();
        if ($componentes->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($componentes);
        // return view('componentes.index', ['componentes'=>$componentes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('componentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'activo_id' => 'required',
            'repuesto_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        
        $componente = Componente::create([
            'cantidad' => $request->cantidad,
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),
            'descripcion' => $request->descripcion,
            'activo_id' => $request->activo_id,
            'repuesto_id' => $request->repuesto_id
        ]);

        $repuesto = Repuesto::find($request->repuesto_id);
        if (!$repuesto) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        $stock = $repuesto->stock;
        if ($request->has('stock')){
            $repuesto->stock = $stock - $request->cantidad;
        }
        
        if (!$componente){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'componente' => $componente,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $componente = Componente::find($id);
        return response()->json($componente);
        // return view('componentes.mostrar', ['componente'=>$componente]);
    }

    /**
     * Display the specified resource.
     */
    public function asignados(string $id)
    {
        $componente = Componente::with('repuesto')->where('activo_id', $id)->get();
        return response()->json($componente);
        // return view('componentes.mostrar', ['componente'=>$componente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $componente = Componente::find($id);
        return response()->json($componente);
        // return view('componentes.mostrar', ['componente'=>$componente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $componente = Componente::find($id);
        if (!$componente) {
            $data = [
                'message' => 'componente no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'cantidad' => 'required',
            'descripcion' => 'required',
            'mantenimiento_id' => 'required',
            'repuesto_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        $componente->cantadad = $request->cantadad;
        $componente->fecha = $request->fecha;
        $componente->descripcion = $request->descripcion;
        $componente->mantenimiento_id = $request->mantenimiento_id;
        $componente->repuesto_id = $request->repuesto_id;
        $componente->save();

        $data = [
            'message'=> 'componente actualizado',
            'componente' => $componente,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

     /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $componente = Componente::find($id);
        if (!$componente) {
            $data = [
                'message' => 'componente no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('cantidad')){
            $componente->cantidad = $request->cantidad;
        }

        if ($request->has('fecha')){
            $componente->fecha = $request->fecha;
        }
        
        if ($request->has('descripcion')){
            $componente->descripcion = $request->descripcion;
        }
        
        if ($request->has('mantenimiento_id')){
            $componente->mantenimiento_id = $request->mantenimiento_id;
        }
        
        if ($request->has('repuesto_id')){
            $componente->repuesto_id = $request->repuesto_id;
        }
        
        $componente->save();

        $data = [
            'message'=> 'componente actualizado',
            'componente' => $componente,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $componente = Componente::find($id);
        if (!$componente) {
            $data = [
                'message' => 'componente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $componente->delete();
        
        $data = [
            'message' => 'componente eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
