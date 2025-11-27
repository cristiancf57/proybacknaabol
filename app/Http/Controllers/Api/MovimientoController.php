<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = Movimiento::all();
        if ($movimientos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($movimientos);
        // return view('movimientos.index', ['movimientos'=>$movimientos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movimientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'tipo_movimiento' => 'required',
            'oreigen' => 'required',
            'destino' => 'required',
            'usuario_id' => 'required',
            'activo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $movimiento = Movimiento::create([
            'tpo_movimiento' => $request->tpo_movimiento,
            'origen' => $request->origen,
            'destino' => $request->destino,
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),
            'estado' => $request->estado ??'nuevo',
            'descripcion' => $request->descripcion,
            'usuario_id' => $request->usuario_id,
            'activo_id' => $request->activo_id,
        ]);
        
        if (!$movimiento){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'movimiento' => $movimiento,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movimiento = Movimiento::find($id);
        return response()->json($movimiento);
        // return view('movimientos.mostrar', ['movimiento'=>$movimiento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movimiento = Movimiento::find($id);
        return response()->json($movimiento);
        // return view('movimientos.editar', ['movimiento'=>$movimiento]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $movimiento = Movimiento::find($id);
        if (!$movimiento) {
            $data = [
                'message' => 'registro de movimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'tipo_movimiento' => 'required',
            'oreigen' => 'required',
            'destino' => 'required',
            'usuario_id' => 'required',
            'activo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        
        $movimiento->tipo_movimiento = $request->tipo_movimiento;
        $movimiento->descripcion = $request->descripcion;
        $movimiento->origen = $request->origen;
        $movimiento->destino = $request->destino;
        $movimiento->fecha = Carbon::now('America/La_Paz')->toDateString();
        $movimiento->estado = $request->estado;
        $movimiento->usuario_id = $request->usuario_id;
        $movimiento->activo_id = $request->activo_id;
        $movimiento->save();

        $data = [
            'message'=> 'movimiento actualizado',
            'movimiento' => $movimiento,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $movimiento = Movimiento::find($id);
        if (!$movimiento) {
            $data = [
                'message' => 'movimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('tipo_movimiento')){
            $movimiento->tipo_movimiento = $request->tipo_movimiento;
        }

        if ($request->has('origen')){
            $movimiento->origen = $request->origen;
        }
        
        if ($request->has('desctino')){
            $movimiento->desctino = $request->desctino;
        }
        
        if ($request->has('fecha')){
            $movimiento->fecha = $request->fecha;
        }
        
        if ($request->has('estado')){
            $movimiento->estado = $request->estado;
        }
        
        if ($request->has('descripcion')){
            $movimiento->descripcion = $request->descripcion;
        }
        
        if ($request->has('usuario_id')){
            $movimiento->usuario_id = $request->usuario_id;
        }
        
        if ($request->has('activo_id')){
            $movimiento->activo_id = $request->activo_id;
        }
        
        $movimiento->save();

        $data = [
            'message'=> 'movimiento actualizado',
            'movimiento' => $movimiento,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movimiento = Movimiento::find($id);

        if (!$movimiento) {
            $data = [
                'message' => 'movimiento no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $movimiento->delete();

        $data = [
            'message' => 'movimiento eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
