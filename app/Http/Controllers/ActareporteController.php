<?php

namespace App\Http\Controllers;

use App\Models\Actareporte;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActareporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actasr = Actareporte::all();
        if ($actasr->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($actasr);
        // return view('actareporte.index',['reportes'=>$actasr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actareporte.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'descripcion' => 'required',
            'usuario_id' => 'required',
            'reporte_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actar = Actareporte::create([
            'foto' => $request->foto ?? 'default.jpg',
            'fecha' => Carbon::now()->toDateString(),   // "2025-08-29"
            'hora'  => Carbon::now()->toTimeString(),   // "15:12:00"
            'descripcion' => $request->descripcion,
            'usuario_id' => $request->usuario_id,
            'reporte_id' => $request->reporte_id
        ]);

        if (!$actar){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'usuario' => $actar,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actar = Actareporte::find($id);
        return response()->json($actar);
        // return view('actareporte.mostrar',['reportes'=>$actar]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $actar = Actareporte::find($id);
        return response()->json($actar);
        // return view('actareporte.edit',['reportes'=>$actar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actar = Actareporte::find($id);
        if (!$actar) {
            $data = [
                'message' => 'acta de reporte no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'descripcion' => 'required',
            'usuario_id' => 'required',
            'reporte_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actar->foto = $request->foto ?? 'default.jpg';
        $actar->fecha= Carbon::now()->toDateString();   // "2025-08-29"
        $actar->hora = Carbon::now()->toTimeString();   // "15:12:00"
        $actar->descripcion = $request->descripcion;
        $actar->usuario_id = $request->usuario_id;
        $actar->reporte_id = $request->reporte_id;
        $actar->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $actar = Actareporte::find($id);
        if (!$actar) {
            $data = [
                'message' => 'acta de reporte no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('foto')){
            $actar->foto = $request->foto;
        }

        if ($request->has('fecha')){
            $actar->fecha = $request->fecha;
        }

        if ($request->has('hora')){
            $actar->hora = $request->hora;
        }
        
        if ($request->has('descripcion')){
            $actar->descripcion = $request->descripcion;
        }
        
        if ($request->has('usuario_id')){
            $actar->usuario_id = $request->usuario_id;
        }
        
        if ($request->has('reporte_id')){
            $actar->reporte_id = $request->reporte_id;
        }
        
        $actar->save();

        $data = [
            'message'=> 'acta de reporte actualizado',
            'acta' => $actar,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actar = Actareporte::find($id);
        if (!$actar) {
            $data = [
                'message' => 'acta de reporte no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $actar->delete();

        $data = [
            'message' => 'acta de reporte eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
