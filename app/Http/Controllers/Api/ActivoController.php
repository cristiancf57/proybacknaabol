<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activo;
use App\Models\Mantenimiento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activos = Activo::orderBy('id', 'desc')->get();
        // return view('activos.intex', ['activos'=>$activos]);
        if ($activos->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($activos);
    }

    /**
     * Obtener estadísticas de activos por tipo
     */
    public function getEstadisticas()
    {
        $estadisticas = Activo::where('estado', 'activo')
            ->selectRaw('tipo as categoria, COUNT(*) as cantidad')
            ->groupBy('tipo')
            ->get();

        if ($estadisticas->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($estadisticas);

    }

    /**
     * buscar por codigo
     */
    public function codig(string $codigo)
    {
        $activo = Activo::where('codigo',$codigo)->get();
        return response()->json($activo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'codigo' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $activo = Activo::create([
            'detalle' => $request->detalle,
            'codigo' => $request->codigo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'serie' => $request->serie,
            'color' => $request->color,
            'area' => $request->area,
            'ip' => $request->ip ?? '0.0.0.0',
            'ubicacion' => $request->ubicacion,
            'estado' => $request->estado ?? 'activo',
            'fecha' => $request->fecha ?? Carbon::now('America/La_Paz')->toDateString(),
            'descripcion' => $request->descripcion ?? '-',
            'tipo' => $request->tipo,
        ]);
        
        // calcular la fecha de reprogramacion
        // Si la fecha cae en sábado → pásala a lunes (+2 días) y Si la fecha cae en domingo → pásala a lunes (+1 día)

        if (in_array($request->tipo, ['computadora', 'laptop', 'miniPC'])) {
            if ($request->fecha) {
                // Convertir a Carbon si es string
                $fecha = Carbon::parse($request->fecha)->addMonths(6);
            } else {
                $fecha = Carbon::now('America/La_Paz')->addMonths(6);
            }
        } elseif ($request->tipo == 'impresora') {
            if ($request->fecha) {
                $fecha = Carbon::parse($request->fecha)->addMonths(3);
            } else {
                $fecha = Carbon::now('America/La_Paz')->addMonths(3);
            }
        } else {
            // Para cualquier otro tipo
            if ($request->fecha) {
                $fecha = Carbon::parse($request->fecha)->addMonths(12);
            } else {
                $fecha = Carbon::now('America/La_Paz')->addMonths(12);
            }
        }

        // Ajustar si es fin de semana
        if ($fecha->isSaturday()) {
            $fecha->addDays(2);
        } elseif ($fecha->isSunday()) {
            $fecha->addDay();
        }

        if(!($request->estado == 'baja')){
            Mantenimiento::create([
                'estado' => 'pendiente',
                'fecha' =>  $fecha->toDateString(),
                'observaciones' =>  $request->detalle,
                'activo_id' => $activo->id,
            ]);
        }
        
        
        if (!$activo){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'activo' => $activo,
            'status' =>201
        ];
        
        return response()->json($data, 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activo = Activo::find($id);
        // return view('activos.mostrar', ['activo'=>$activo]);
        return response()->json($activo);
    }
    
    /**
     * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        $activo = Activo::find($id);
        // return view('activos.edit', ['activo'=>$activo]);
        return response()->json($activo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activo = Activo::find($id);
        if (!$activo) {
            $data = [
                'message' => 'actividad no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'detalle' => 'required',
            'codigo' => 'required',
            'marca' => 'required',
            'color' => 'required',
            'estado' => 'required',
            'descripcion' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $activo->detalle = $request->detalle;
        $activo->codigo = $request->codigo;
        $activo->marca = $request->marca;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->color = $request->color;
        $activo->area = $request->area;
        $activo->ip = $request->ip;
        $activo->ubicacion = $request->ubicacion;
        $activo->estado = $request->estado;
        $activo->fecha = $request->fecha;
        $activo->descripcion = $request->descripcion;
        $activo->tipo = $request->tipo;
        $activo->save();

        if ($request->estado == 'baja'){
            $mantenimiento = Mantenimiento::where('activo_id', $id)->first();
            if (!$mantenimiento) {
                $data = [
                    'message' => 'mantenimiento no encontrado',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }

            $mantenimiento->delete();
        }else{
            // Para cualquier otro tipo
            if ($request->fecha) {
                $fecha = Carbon::parse($request->fecha)->addMonths(12);
            } else {
                $fecha = Carbon::now('America/La_Paz')->addMonths(12);
            }

            // Ajustar si es fin de semana
            if ($fecha->isSaturday()) {
                $fecha->addDays(2);
            } elseif ($fecha->isSunday()) {
                $fecha->addDay();
            }
            Mantenimiento::create([
                'estado' => 'pendiente',
                'fecha' =>  $fecha->toDateString(),
                'observaciones' =>  $request->detalle,
                'activo_id' => $activo->id,
            ]);
        }
        

        $data = [
            'message'=> 'actividad actualizado',
            'actividad' => $activo,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $activo = Activo::find($id);
        if (!$activo) {
            $data = [
                'message' => 'activo no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('detalle')){
            $activo->detalle = $request->detalle;
        }

        if ($request->has('codigo')){
            $activo->codigo = $request->codigo;
        }
        
        if ($request->has('marca')){
            $activo->marca = $request->marca;
        }
        
        if ($request->has('modelo')){
            $activo->modelo = $request->modelo;
        }
        
        if ($request->has('serie')){
            $activo->serie = $request->serie;
        }
        
        if ($request->has('color')){
            $activo->color = $request->color;
        }
        
        if ($request->has('area')){
            $activo->area = $request->area;
        }
        
        if ($request->has('ip')){
            $activo->ip = $request->ip;
        }
        
        if ($request->has('ubicacion')){
            $activo->ubicacion = $request->ubicacion;
        }
        
        if ($request->has('estado')){
            $activo->estado = $request->estado;
        }
        
        if ($request->has('fecha')){
            $activo->fecha = $request->fecha;
        }
        
        if ($request->has('descripcion')){
            $activo->descripcion = $request->descripcion;
        }
        
        if ($request->has('tipo_id')){
            $activo->tipo = $request->tipo;
        }
        
        $activo->save();

        if ($request->estado == 'baja'){
            $mantenimiento = Mantenimiento::where('activo_id', $id)->first();
            if (!$mantenimiento) {
                $data = [
                    'message' => 'mantenimiento no encontrado',
                    'status' => 404
                ];
                return response()->json($data, 404);
            }

            $mantenimiento->delete();
        }

        $data = [
            'message'=> 'activo actualizado',
            'activo' => $activo,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activo = Activo::find($id);

        if (!$activo) {
            $data = [
                'message' => 'activo no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        
        $activo->delete();

        $data = [
            'message' => 'actividad eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
