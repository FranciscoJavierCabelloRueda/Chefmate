<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Tag(
 *     name="Comentarios",
 *     description="Endpoints relacionados con comentarios en recetas"
 * )
 */
class ComentarioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/comentarios/receta/{id}",
     *     summary="Listar comentarios de una receta",
     *     tags={"Comentarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la receta",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Comentarios obtenidos correctamente"),
     *     @OA\Response(response=404, description="No se encontraron comentarios"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function listar($idRec)
    {
        try {
            $comentarios = Comentario::with('usuarios')
                ->where('idRec', $idRec)
                ->orderByDesc('fecha_creacion')
                ->get()
                ->each(function ($comentario) {
                    $comentario->makeVisible('idUsu');
                });

            if ($comentarios->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'error' => 'Not Found',
                    'mensaje' => 'No se encontraron comentarios para esta receta.'
                ], 404);
            }

            return response()->json([
                'status' => 200,
                'mensaje' => 'Comentarios obtenidos correctamente',
                'comentarios' => $comentarios
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al obtener los comentarios.'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/comentarios",
     *     summary="Crear un nuevo comentario",
     *     tags={"Comentarios"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comentario", "valoracion", "idRec"},
     *             @OA\Property(property="comentario", type="string", example="Muy buena receta"),
     *             @OA\Property(property="valoracion", type="integer", example=5),
     *             @OA\Property(property="idRec", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Comentario creado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function guardar(Request $request)
{
    try {
        $validated = $request->validate([
            'comentario' => 'required|string|max:1000',
            'valoracion' => 'required|integer|min:1|max:5',
            'idRec' => 'required|exists:receta,idRec',
        ]);

        $nuevo = Comentario::create([
            'comentario' => $validated['comentario'],
            'valoracion' => $validated['valoracion'],
            'idRec' => $validated['idRec'],
            'idUsu' => Auth::id(),
            'fecha_creacion' => Carbon::now(),
            'fecha_actualizacion' => Carbon::now(),
        ]);

        $comentario = $nuevo->load('usuarios');
        $comentario->makeVisible('idUsu');

        return response()->json([
            'status' => 201,
            'mensaje' => 'Comentario creado correctamente',
            'comentario' => $comentario
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
            'mensaje' => 'Error al crear el comentario.'
        ], 500);
    }
}

    /**
     * @OA\Put(
     *     path="/comentarios/{id}",
     *     summary="Actualizar un comentario propio",
     *     tags={"Comentarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="comentario", type="string", example="Comentario editado"),
     *             @OA\Property(property="valoracion", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Comentario actualizado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=403, description="No autorizado para modificar este comentario"),
     *     @OA\Response(response=404, description="Comentario no encontrado"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function actualizar(Request $request, $id)
    {
        try {
            $comentario = Comentario::where('idUsu', Auth::id())->findOrFail($id);

            $request->validate([
                'comentario' => 'sometimes|string|max:1000',
                'valoracion' => 'sometimes|integer|min:1|max:5',
            ]);

            if ($request->has('comentario')) {
                $comentario->comentario = $request->comentario;
            }

            if ($request->has('valoracion')) {
                $comentario->valoracion = $request->valoracion;
            }

            $comentario->fecha_actualizacion = Carbon::now();
            $comentario->save();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Comentario actualizado correctamente',
                'comentario' => $comentario->load('usuarios')
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'error' => 'Not Found',
                'mensaje' => 'Comentario no encontrado o no autorizado.'
            ], 404);
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
                'mensaje' => 'Error al actualizar el comentario.'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/comentarios/{id}",
     *     summary="Eliminar un comentario propio",
     *     tags={"Comentarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Comentario eliminado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=403, description="No autorizado para eliminar este comentario"),
     *     @OA\Response(response=404, description="Comentario no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function eliminar($id)
    {
        try {
            $comentario = Comentario::where('idUsu', Auth::id())->findOrFail($id);
            $comentario->delete();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Comentario eliminado correctamente'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'error' => 'Not Found',
                'mensaje' => 'Comentario no encontrado o no autorizado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al eliminar el comentario.'
            ], 500);
        }
    }
}