<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Endpoints relacionados con usuarios"
 * )
 */
class UsuarioController extends Controller
{
    /**
     * @OA\Post(
     *     path="/usuarios",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "apellidos", "email", "password"},
     *             @OA\Property(property="nombre", type="string", example="Laura"),
     *             @OA\Property(property="apellidos", type="string", example="Martínez Ruiz"),
     *             @OA\Property(property="email", type="string", example="laura@chefmate.com"),
     *             @OA\Property(property="password", type="string", example="secreto123"),
     *             @OA\Property(property="foto", type="string", format="binary", example="")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuario registrado correctamente"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function registrar(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'email' => 'required|email|unique:usuario,email',
                'password' => 'required|string|min:8',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            ]);

            $rutaFoto = null;
            if ($request->hasFile('foto')) {
                $rutaFoto = $request->file('foto')->store('fotos_usuarios', 'private');
            }

            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'password' => $request->password,
                'foto' => $rutaFoto,
                'admin' => false,
            ]);

            return response()->json([
                'status' => 201,
                'mensaje' => 'Usuario registrado correctamente',
                'usuario' => $usuario
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'error' => 'Unprocessable Entity',
                'mensaje' => 'Datos inválidos',
                'errores' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al registrar el usuario.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/usuario",
     *     summary="Obtener los datos del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Datos del usuario obtenidos correctamente"),
     *     @OA\Response(response=401, description="No autorizado")
     * )
     */
    public function obtenerDatos()
    {
        try {
            $usuario = Auth::user();

            return response()->json([
                'status' => 200,
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al obtener los datos del usuario.'
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/usuario",
     *     summary="Actualizar el perfil del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan"),
     *             @OA\Property(property="apellidos", type="string", example="Pérez García"),
     *             @OA\Property(property="password", type="string", example="nuevoPassword123"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Perfil actualizado correctamente"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function actualizar(Request $request)
    {
        try {
            $usuario = Auth::user();

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'apellidos' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:usuario,email,',
                'password' => 'sometimes|nullable|string|min:8',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            ]);

            if ($request->hasFile('foto')) {
                if ($usuario->foto) Storage::disk('private')->delete($usuario->foto);
                $usuario->foto = $request->file('foto')->store('fotos_usuarios', 'private');
            }

            if (isset($validated['nombre'])) {
                $usuario->nombre = $validated['nombre'];
            }
            if (isset($validated['apellidos'])) {
                $usuario->apellidos = $validated['apellidos'];
            }
            if (isset($validated['email'])) {
                $usuario->email = $validated['email'];
            }
            if (isset($validated['password'])) {
                $usuario->password = Hash::make($validated['password']);
            }

            $usuario->save();
            $usuario->refresh();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Perfil actualizado correctamente',
                'usuario' => $usuario
            ]);
            
        } catch (\Exception $e) {         
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al actualizar los datos.'
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/usuario",
     *     summary="Eliminar la cuenta del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Cuenta eliminada correctamente"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function eliminar()
    {
        try {
            $usuario = Auth::user();

            if ($usuario->foto) {
                Storage::disk('private')->delete($usuario->foto);
            }

            $usuario->delete();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Cuenta eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al eliminar la cuenta.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/usuario/foto",
     *     summary="Mostrar la foto del usuario autenticado",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Foto mostrada correctamente"),
     *     @OA\Response(response=404, description="Foto no disponible")
     * )
     */
    public function mostrarFoto()
    {
        $usuario = Auth::user();

        if (!$usuario->foto || !Storage::disk('private')->exists($usuario->foto)) {
            return response()->json([
                'status' => 404,
                'error' => 'Not Found',
                'mensaje' => 'Foto no disponible'
            ], 404);
        }

        return response()->file(storage_path('app/private/' . $usuario->foto));
    }
}