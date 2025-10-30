<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Events\UserLoggedIn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'login' => 'required|string',
                'password' => 'required|min:6'
            ]);

            // Determinar si el login es email o username
            $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $authCredentials = [
                $loginType => $credentials['login'],
                'password' => $credentials['password']
            ];

            if (!Auth::attempt($authCredentials)) {
                // RateLimiter::hit($throttleKey);
                return response()->json([
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            $user = Auth::user();
            
            // Crear token personalizado sin Sanctum
            $token = base64_encode(json_encode([
                'user_id' => $user->id,
                'expires_at' => now()->addDays(7)->timestamp
            ]));

            return response()->json([
                'user' => $this->getUserData($user),
                'token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Contacte al administrador'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cerrar sesión'
            ], 500);
        }
    }

    public function user(Request $request)
    {
        try {
            $user = $request->user();
            
            return response()->json([
                'user' => $this->getUserData($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener información del usuario'
            ], 500);
        }
    }

    protected function getUserData($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ];
    }

    // Método adicional para registro (opcional)
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            // Asignar rol por defecto (opcional)
            $user->assignRole('user');

            Auth::login($user);
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $this->getUserData($user),
                'token' => $token,
                'token_type' => 'Bearer',
                'message' => 'Usuario registrado exitosamente'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Contacte al administrador'
            ], 500);
        }
    }
}
