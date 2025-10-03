<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
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
            'estado' => 'required',
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

        $actividad = tarea::create([
            'detalle' => $request->detalle,
            'tipo_reporte' => $request->tipo_reporte,
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),  // "2025-08-29"
            'hora'  => Carbon::now('America/La_Paz')->toTimeString(),  // "15:12:00"
            'estado' => $request->estado,
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
        $reporte->foto = $request->foto;
        $reporte->fecha = Carbon::now()->toDateString();  // "2025-08-29"
        $reporte->hora = Carbon::now()->toTimeString();  // "15:12:00"
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
