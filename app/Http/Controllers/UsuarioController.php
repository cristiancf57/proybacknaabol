<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        if ($usuarios->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($usuarios);
        
        // return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'nombre' => 'required|max:60',
            'apellido' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'username' => 'required',
            'password' => 'required',
            'cargo_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $usuario = User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'email_verified_at' => Carbon::now('America/La_Paz'),
            'telefono' => $request->telefono,
            'username' => $request->username,
            'password' => $request->password,
            'cargo_id' => $request->cargo_id
        ]);
        
        if (!$usuario){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $usuario,
            'status' =>201
        ];
        return response()->json($data, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);
        return response()->json($usuario);
        // return view('usuarios.mostrar',['usuario'=> $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::find($id);
        return response()->json($usuario);
        // return view('usuarios.edit',['usuario'=>$usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        $validator = validator($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'username' => 'required',
            'password' => 'required',
            'cargo_id' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        
        // $usuario = User::find($id);
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->username = $request->username;
        $usuario->password = $request->password;
        $usuario->cargo_id = $request->cargo_id;
        $usuario->save();

        $data = [
            'message'=> 'Usuario actualizado',
            'usuario' => $usuario,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePartial(Request $request, string $id) {
        $usuario = User::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'nombre' => 'max:60',
            'apellido' => 'max:50',
            'email' => 'email',
            'telefono' => 'max:15',
            'username' => 'max:40',
            'password' => 'max:255',
            'cargo_id' => 'max:5'
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }
        
        if ($request->has('nombre')){
            $usuario->nombre = $request->nombre;
        }

        if ($request->has('apellido')){
            $usuario->apellido = $request->apellido;
        }
        
        if ($request->has('email')){
            $usuario->email = $request->email;
        }
        
        if ($request->has('telefono')){
            $usuario->telefono = $request->telefono;
        }
        
        if ($request->has('username')){
            $usuario->username = $request->username;
        }
        
        if ($request->has('password')){
            $usuario->password = $request->password;
        }
        
        if ($request->has('cargo_id')){
            $usuario->cargo_id = $request->cargo_id;
        }
        
        $usuario->save();

        $data = [
            'message'=> 'Usuario actualizado',
            'usuario' => $usuario,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $usuario->delete();

        $data = [
            'message' => 'Usuario eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
