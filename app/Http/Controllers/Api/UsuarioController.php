<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $usuarios = User::all();
        // $usuarios = User::with('cargo')->get();
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
            'username' => 'required',
            'password' => 'required'
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
            'password' => $request->password
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
            'password' => 'required'
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
        $usuario->perfil = $request->perfil;
        $usuario->username = $request->username;
        $usuario->password = $request->password;
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

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('perfiles', 'public');
            $usuario->update(['perfil' => $path]);
        }

        if ($request->has('perfil')){
            $usuario->perfil = $request->perfil;
        }
        
        if ($request->has('username')){
            $usuario->username = $request->username;
        }
        
        if ($request->has('password')){
            $usuario->password = $request->password;
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

    /**
     * obtener a usuarios
     */
    public function roles()
    {
        // $roles = Role::all();
        $roles = Role::with('permissions')->get();
        if ($roles->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($roles);
    }

    /**
     * obtener permisos
     */
    public function permissions()
    {
        $permissions = Permission::all();
        if ($permissions->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($permissions);
    }

    /**
     * Asignar un rol a un usuario
     */
    public function assignRole(Request $request, $userId)
    {
        try {
            $request->validate([
                'role' => 'required|string|exists:roles,name'
            ]);

            $user = User::findOrFail($userId);
            $user->assignRole($request->role);

            // Recargar el usuario con roles y permisos
            $user->load('roles', 'permissions');

            return response()->json([
                'success' => true,
                'message' => 'Rol asignado correctamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->nombre,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar rol'
            ], 500);
        }
    }

    /**
     * Sincronizar múltiples roles (reemplaza todos los roles)
     */
    public function syncRoles(Request $request, $userId)
    {
        try {
            $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'string|exists:roles,name'
            ]);

            $user = User::findOrFail($userId);
            $user->syncRoles($request->roles);

            $user->load('roles', 'permissions');

            return response()->json([
                'success' => true,
                'message' => 'Roles sincronizados correctamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al sincronizar roles'
            ], 500);
        }
    }

    /**
     * Remover un rol de un usuario
     */
    public function removeRole(Request $request, $userId)
    {
        try {
            $request->validate([
                'role' => 'required|string|exists:roles,name'
            ]);

            $user = User::findOrFail($userId);
            $user->removeRole($request->role);

            $user->load('roles', 'permissions');

            return response()->json([
                'success' => true,
                'message' => 'Rol removido correctamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al remover rol'
            ], 500);
        }
    }

    /**
     * Obtener usuarios con sus roles
     */
    public function getUsersWithRoles()
    {
        try {
            $users = User::with('roles')->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ];
            });

            return response()->json([
                'success' => true,
                'users' => $users
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener usuarios'
            ], 500);
        }
    }
}
