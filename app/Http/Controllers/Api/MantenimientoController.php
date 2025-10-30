<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mantenimientos = Mantenimiento::with('activo')->orderBy('id', 'desc')->get();
        if ($mantenimientos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($mantenimientos);
        // return view('mantenimientos.index', ['mantenimientos'=>$mantenimientos]);
    }
    /**
     * Display a listing of the resource.
     */
    public function calendar()
    {
        $mantenimientos = Mantenimiento::with('activo')->get();
        if ($mantenimientos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($mantenimientos);
        // return view('mantenimientos.index', ['mantenimientos'=>$mantenimientos]);
    }

    /**
     * Display a listing of the resource.
     */
    public function detalle()
    {
        $mantenimientos = Mantenimiento::with('activo')->where('estado', 'pendiente')->orderBy('fecha', 'asc')->limit(7)->get();
        if ($mantenimientos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($mantenimientos);
        // return view('mantenimientos.index', ['mantenimientos'=>$mantenimientos]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mantenimientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   $validator = validator($request->all(),[
            'activo_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $mantenimiento = Mantenimiento::create([
            'estado' => $request->estado ?? 'pendiente',
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),
            'activo_id' => $request->activo_id
        ]);
        
        if (!$mantenimiento){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $mantenimiento,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        // return view('mantenimientos.mostrar', ['mantenimiento'=>$mantenimiento]);
        return response()->json($mantenimiento);
    }

    /**
     * buscar por activo_id
     */
    public function activ(string $id)
    {
        $mantenimiento = Mantenimiento::where('activo_id',$id)->orderBy('fecha','desc')->get();

        if ($mantenimiento->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($mantenimiento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        // return view('mantenimientos.edit', ['Mantenimiento'=>$mantenimiento]);
        return response()->json($mantenimiento);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mantenimiento = Mantenimiento::find($id);
        if (!$mantenimiento) {
            $data = [
                'message' => 'mantenimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'estado' => 'required',
            'observaciones' => 'required',
            'activo_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $mantenimiento->estado = $request->estado;
        $mantenimiento->fecha = $request->fecha;
        $mantenimiento->observaciones = $request->observaciones;
        $mantenimiento->activo_id = $request->activo_id;
        $mantenimiento->save();

        $data = [
            'message'=> 'mantenimiento actualizado',
            'mantenimiento' => $mantenimiento,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

     /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $mantenimiento = Mantenimiento::find($id);
        if (!$mantenimiento) {
            $data = [
                'message' => 'registro de mantenimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        if ($request->has('estado')){
            $mantenimiento->estado = $request->estado;
        }
        
        if ($request->has('fecha')){
            $mantenimiento->fecha = $request->fecha;
        }
        
        if ($request->has('observaciones')){
            $mantenimiento->observaciones = $request->observaciones;
        }
        
        if ($request->has('activo_id')){
            $mantenimiento->activo_id = $request->activo_id;
        }
        
        $mantenimiento->save();

        $data = [
            'message'=> 'mantenimiento actualizado',
            'mantenimiento' => $mantenimiento,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Actualizar el estado the specified resource in storage.
     */
    public function updateEstado(Request $request, string $id, $estado) {
        $mantenimiento = Mantenimiento::find($id);

        if ($request->has('estado')){
            $mantenimiento->estado = $request->estado;
        }
        
        if ($request->has('fecha')){
            $mantenimiento->fecha = $request->fecha;
        }
        
        if ($request->has('observaciones')){
            $mantenimiento->observaciones = $request->observaciones;
        }
        
        if ($request->has('activo_id')){
            $mantenimiento->activo_id = $request->activo_id;
        }
        
        $mantenimiento->save();

        $data = [
            'message'=> 'mantenimiento actualizado',
            'mantenimiento' => $mantenimiento,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (!$mantenimiento) {
            $data = [
                'message' => 'mantenimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $mantenimiento->delete();

        $data = [
            'message' => 'mantenimiento eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
