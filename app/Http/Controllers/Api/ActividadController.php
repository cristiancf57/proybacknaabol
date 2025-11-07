<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acta;
use App\Models\Actividad;
use App\Models\Mantenimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actividades = Actividad::all();
        if ($actividades->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($actividades);
    }

     /**
     * Display a listing of the resource.
     */
    public function detalle()
    {
        $actividades = Actividad::with(['mantenimiento','mantenimiento.activo'])->get();
        if ($actividades->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($actividades);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actividades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'tipo_mantenimiento' => 'required',
            'mantenimiento_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad = Actividad::create([
            'foto' => $request->foto ?? 'default.jpg',
            'fecha' => Carbon::now('America/La_Paz')->toDateString(),
            'tipo_mantenimiento' => $request->tipo_mantenimiento,
            'limpieza' => $request->limpieza,
            'sistema_operativo' => $request->sistema_operativo,
            'archivos' => $request->archivos,
            'hardware' => $request->hardware,
            'software' => $request->software,
            'encargado' => $request->encargado ?? '.',
            'tecnico' => $request->tecnico ?? '.',
            'supervisor' => $request->supervisor ?? '.',
            'observaciones' => $request->observaciones ?? '.',
            'mantenimiento_id' => $request->mantenimiento_id
        ]);

        $id =$request->mantenimiento_id;
        $mantenimiento = Mantenimiento::find($id);
        if ($request->has('estado')){
            $mantenimiento->estado = 'culminado';
        }

        $estado = Mantenimiento::find($request->mantenimiento_id);
        if ($request->has('estado')){
            $estado->estado = $request->estado;
        }
        $estado->save();

        // calcular la fecha de reprogramacion
        $fecha = Carbon::now('America/La_Paz')->addMonths(12);
        // Si la fecha cae en sábado → pásala a lunes (+2 días)
        // Si la fecha cae en domingo → pásala a lunes (+1 día)
        if ($fecha->isSaturday()) {
            $fecha->addDays(2);
        } elseif ($fecha->isSunday()) {
            $fecha->addDay();
        }

         Mantenimiento::create([
            'estado' => 'pendiente',
            'observaciones'=>'Mantenimiento posterior',
            'fecha' =>  $fecha->toDateString(),
            'activo_id' => $request->mantenimiento_id,
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
        // $actividad = Actividad::find($id);
        $actividad = Actividad::with(['mantenimiento','mantenimiento.activo'])->find($id);
        return response()->json($actividad);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $actividad = Actividad::find($id);
        return response()->json($actividad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actividad = Actividad::find($id);
        if (!$actividad) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'tipo_mantenimiento' => 'required',
            'limpieza' => 'required',
            'sistema_operativo' => 'required',
            'arcrivos' => 'required',
            'hardware' => 'required',
            'software' => 'required',
            'mantenimiento_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad->foto = $request->foto ?? 'default.jpg';
        $actividad->fecha = Carbon::now('America/La_Paz')->toDateString(); 
        $actividad->tipo_mantenimiento = $request->tipo_mantenimiento;
        $actividad->limpieza = $request->limpieza;
        $actividad->sistema_operativo = $request->sistema_operativo;
        $actividad->archivos = $request->archivos;
        $actividad->hardware = $request->hardware;
        $actividad->software = $request->software;
        $actividad->encargado = $request->encargado;
        $actividad->tecnico = $request->tecnico;
        $actividad->supervisor = $request->supervisor;
        $actividad->observaciones =$request->observaciones;
        $actividad->mantenimiento_id = $request->mantenimiento_id;
        $actividad->save();

        $data = [
            'message'=> 'actividad actualizado',
            'actividad' => $actividad,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
    * Update the specified resource in storage.
    */
    public function updatePartial(Request $request, string $id) {
        $actividad = Actividad::find($id);
        if (!$actividad) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('foto')){
            $actividad->foto = $request->foto;
        }

        if ($request->has('fecha')){
            $actividad->fecha = $request->fecha;
        }
        
        if ($request->has('tipo_mantenimiento')){
            $actividad->tipo_mantenimiento = $request->tipo_mantenimiento;
        }
        
        if ($request->has('limpieza')){
            $actividad->limpieza = $request->limpieza;
        }
        
        if ($request->has('sistema_operativo')){
            $actividad->sistema_operativo = $request->sistema_operativo;
        }
        
        if ($request->has('archivos')){
            $actividad->archivos = $request->archivos;
        }
        
        if ($request->has('hardware')){
            $actividad->hardware = $request->hardware;
        }
        
        if ($request->has('software')){
            $actividad->software = $request->software;
        }
        
        if ($request->has('encargado')){
            $actividad->encargado = $request->encargado;
        }
        
        if ($request->has('tecnico')){
            $actividad->tecnico = $request->tecnico;
        }
        
        if ($request->has('supervisor')){
            $actividad->supervisor = $request->supervisor;
        }
        
        if ($request->has('observaciones')){
            $actividad->observaciones = $request->observaciones;
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
        $actividad = Actividad::find($id);

        if (!$actividad) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $actividad->delete();

        $data = [
            'message' => 'actividad eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
