<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Tag(
 *     name="Listas",
 *     description="Endpoints relacionados con listas de recetas"
 * )
 */
class ListaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/listas",
     *     summary="Listar listas del usuario autenticado",
     *     tags={"Listas"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Listas obtenidas correctamente"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function listar()
    {
        try {
            $usuario = Auth::user();
            $listas = $usuario->listas()->with('recetas')->get();

            $listas->transform(function ($lista) {
                $lista->recetas->transform(function ($receta) {
                    if ($receta->foto) {
                        $receta->foto = url('storage/' . $receta->foto);
                    }
                    return $receta;
                });
                return $lista;
            });

            return response()->json([
                'status' => 200,
                'mensaje' => 'Listas obtenidas correctamente',
                'listas' => $listas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'mensaje' => 'Error al obtener las listas'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/listas",
     *     summary="Crear una nueva lista",
     *     tags={"Listas"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre_lista"},
     *             @OA\Property(property="nombre_lista", type="string", example="Recetas favoritas"),
     *             @OA\Property(property="recetas", type="array", @OA\Items(type="integer"), example={1})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Lista creada correctamente"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function guardar(Request $request)
    {
        try {
            $request->validate([
                'nombre_lista' => 'required|string|max:255',
                'recetas' => 'array',
                'recetas.*' => 'exists:receta,idRec',
            ]);

            $lista = Lista::create([
                'nombre_lista' => $request->nombre_lista,
                'idUsu' => Auth::id(),
            ]);

            if ($request->has('recetas')) {
                $lista->recetas()->sync($request->recetas);
            }

            return response()->json([
                'status' => 201,
                'mensaje' => 'Lista creada correctamente',
                'lista' => $lista->load('recetas')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'mensaje' => 'Datos inválidos',
                'errores' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'mensaje' => 'Error al crear la lista'
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/listas/{id}",
     *     summary="Actualizar una lista",
     *     tags={"Listas"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la lista",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre_lista", type="string", example="Actualizado"),
     *             @OA\Property(property="recetas", type="array", @OA\Items(type="integer"), example={1, 2, 3})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Lista actualizada correctamente"),
     *     @OA\Response(response=404, description="Lista no encontrada"),
     *     @OA\Response(response=422, description="Datos inválidos"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function actualizar(Request $request, $id)
    {
        try {
            $lista = Lista::where('idUsu', Auth::id())->findOrFail($id);

            $request->validate([
                'nombre_lista' => 'sometimes|string|max:255',
                'recetas' => 'array',
                'recetas.*' => 'exists:receta,idRec',
            ]);

            if ($request->has('nombre_lista')) {
                $lista->nombre_lista = $request->nombre_lista;
            }

            $lista->save();

            if ($request->has('recetas')) {
                $lista->recetas()->sync($request->recetas);
            }

            return response()->json([
                'status' => 200,
                'mensaje' => 'Lista actualizada correctamente',
                'lista' => $lista->load('recetas')
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'mensaje' => 'Lista no encontrada'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'mensaje' => 'Datos inválidos',
                'errores' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'mensaje' => 'Error al actualizar la lista'
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/listas/{id}",
     *     summary="Eliminar una lista",
     *     tags={"Listas"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la lista",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lista eliminada correctamente"),
     *     @OA\Response(response=404, description="Lista no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function eliminar($id)
    {
        try {
            $lista = Lista::where('idUsu', Auth::id())->findOrFail($id);
            $lista->recetas()->detach();
            $lista->delete();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Lista eliminada correctamente'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'mensaje' => 'Lista no encontrada'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'mensaje' => 'Error al eliminar la lista'
            ], 500);
        }
    }
}