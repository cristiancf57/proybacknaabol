<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Designacion;
use App\Models\User;
use Illuminate\Http\Request;

class DesignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designacion = Designacion::all();
        if ($designacion->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($designacion);
    }

    /**
     * Display a listing of the resource.
     */
    public function detalle()
    {
        $designacion = with('usuario','cargo')->get();
        if ($designacion->isEmpty()){
            $data = [
                'message'=> 'Nose encontro el registro',
                'status'=> 200
            ];
            return response()->json($data,200);
        }
        return response()->json($designacion);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deignaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = validator($request->all(),[
            'estado' => 'required',
            'usuario_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $actividad = Designacion::create([
            'estado' => $request->estado,
            'fecha_inicio'=>$request->fecha_inicio,
            'usuario_id' => $request->usuario_id,
            'cargo_id' => $request->cargo_id
        ]);
        
        if (!$actividad){
            $data = [
                'message' => 'Error al crear los registros',
                'status' =>500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $actividad,
            'status' =>201
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $designacion = Designacion::with(['cargo'])->find($id);
        return response()->json($designacion);
    }

    /**
     * obtener toda las designaciones
     */
    public function design(string $id)
    {
        $designacion = Designacion::where('usuario_id', $id)->where('estado', 'activo')->with('cargo')->first();

        if (!$designacion) {
            return response()->json([
                'message' => 'No se encontró designación activa para este usuario'
            ], 404);
        }
        
        return response()->json($designacion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $designacion = Designacion::find($id);
        return response()->json($designacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'designacion no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }

        $validator = validator($request->all(),[
            'estado' => 'required',
            'usuario_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()){
            $data = [
                'mesaje'=> 'error en la validacion de los datos',
                'error'=> $validator->errors(),
                'status'=> 400
            ];
            return response()->json($data, 400);
        }

        $designacion->estado = $request->estado;
        $designacion->fecha_inicio = $request->fecha_inicio;
        $designacion->fecha_fin = $request->fecha_fin;
        $designacion->usuario_id = $request->usuario_id;
        $designacion->cargo_id = $request->cargo_id;
        $designacion->save();

        $data = [
            'message'=> 'designaicion actualizado',
            'designaicion' => $designacion,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
    * Update the specified resource in storage.
    */
    public function updatePartial(Request $request, string $id) {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'designacion no encontrado',
                'status' => 404
            ];
            return response()->json($data,404);
        }
        
        if ($request->has('estado')){
            $designacion->estado = $request->estado;
        }

        if ($request->has('fecha_inicio')){
            $designacion->fecha_inicio = $request->fecha_inicio;
        }
        
        if ($request->has('fecha_fin')){
            $designacion->fecha_fin = $request->fecha_fin;
        }
        
        if ($request->has('usuario_id')){
            $designacion->usuario_id = $request->usuario_id;
        }
        
        if ($request->has('cargo_id')){
            $designacion->cargo_id = $request->cargo_id;
        }
        
        $designacion->save();

        $data = [
            'message'=> 'desi$designacion actualizado',
            'desi$designacion' => $designacion,
            'status' =>200
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designacion = Designacion::find($id);
        if (!$designacion) {
            $data = [
                'message' => 'dato no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $designacion->delete();

        $data = [
            'message' => 'designacion eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    /**
     * obtener a usuarios
     */
    // public function roles()
    // {
    //     // $roles = Role::all();
    //     $roles = Role::with('permissions')->get();
    //     if ($roles->isEmpty()){
    //         $data = [
    //             'message'=> 'Nose encontro el registro',
    //             'status'=> 200
    //         ];
    //         return response()->json($data,200);
    //     }
    //     return response()->json($roles);
    // }

    /**
     * obtener permisos
     */
    // public function permissions()
    // {
    //     $permissions = Permission::all();
    //     if ($permissions->isEmpty()){
    //         $data = [
    //             'message'=> 'Nose encontro el registro',
    //             'status'=> 200
    //         ];
    //         return response()->json($data,200);
    //     }
    //     return response()->json($permissions);
    // }

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
