<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actareporte;
use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reportes = Tarea::all();
        if ($reportes->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($reportes);
        // return view('reportes.index',['reportes'=>$reportes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reportes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'detalle' => 'required',
            'tipo_reporte' => 'required',
            'personal' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad = Tarea::create([
            'detalle' => $request->detalle,
            'tipo_reporte' => $request->tipo_reporte,
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),  // "2025-08-29"
            'hora'  => Carbon::now('America/La_Paz')->toTimeString(),  // "15:12:00"
            'estado' => 'nuevo',
            'personal' => $request->personal
        ]);
        
        if (!$actividad){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'actividad' => $actividad,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reporte = Tarea::find($id);
        return response()->json($reporte);
        // return view('reportes.mostrar',['reportes'=>$reporte]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reporte = Tarea::find($id);
        return response()->json($reporte);
        // return view('reportes.edit',['reportes'=>$reporte]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reporte = Tarea::find($id);
        if (!$reporte) {
            $data = [
                'message' => 'reporte no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $reporte->detalle = $request->detalle;
        $reporte->tipo_reporte = $request->tipo_reporte;
        // $reporte->fecha = Carbon::now()->toDateString();
        // $reporte->hora = Carbon::now()->toTimeString();
        $reporte->estado = $request->estado;
        $reporte->personal = $request->personal;
        
        $reporte->save();

        $data = [
            'message'=> 'reporte actualizado',
            'reporte' => $reporte,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

     /**
    * Update the specified resource in storage.
    */
    public function updatePartial(Request $request, string $id) {
        $actividad = Tarea::find($id);
        if (!$actividad) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('detalle')){
            $actividad->detalle = $request->detalle;
        }

        if ($request->has('tipo_reporte')){
            $actividad->tipo_reporte = $request->tipo_reporte;
        }
        
        if ($request->has('estado')){
            
            if ($request->estado == 'culminado'){
                Actareporte::create([
                    'foto' => $request->foto ?? 'default.jpg',
                    'fecha' => Carbon::now()->toDateString(),
                    'hora'  => Carbon::now()->toTimeString(),
                    'descripcion' => $request->descripcion, 
                    'usuario_id' => $request->usuario_id,
                    'reporte_id' => $request->id
                ]);
            }
            $actividad->estado = $request->estado;
        }
        
        $actividad->save();

        $data = [
            'message'=> 'actividad actualizado',
            'actividad' => $actividad,
            'status' =>200
        ];
        return response()->json($data, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reporte = Tarea::find($id);
        if (!$reporte) {
            $data = [
                'message' => 'reporte no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $reporte->delete();

        $data = [
            'message' => 'reporte eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
