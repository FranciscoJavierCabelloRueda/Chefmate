<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Recetas",
 *     description="Endpoints relacionados con recetas"
 * )
 */
class RecetaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/recetas",
     *     summary="Listar todas las recetas con su autor",
     *     tags={"Recetas"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Recetas obtenidas correctamente"
     *     ),
     *     @OA\Response(response=404, description="No se encontraron recetas"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function listar()
    {
        try {
            $recetas = Receta::with('usuario')->get();

            if ($recetas->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'error' => 'Not Found',
                    'mensaje' => 'No se encontraron recetas.'
                ], 404);
            }

            $recetas->transform(function ($receta) {
                if ($receta->foto) {
                    $receta->foto = url('storage/' . $receta->foto);
                }
                return $receta;
            });

            return response()->json([
                'status' => 200,
                'mensaje' => 'Recetas obtenidas correctamente',
                'recetas' => $recetas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al obtener las recetas.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/recetas/{id}",
     *     summary="Obtener una receta específica con sus detalles",
     *     tags={"Recetas"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID de la receta", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Receta obtenida correctamente"),
     *     @OA\Response(response=404, description="Receta no encontrada"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function obtener($id)
    {
        try {
            $receta = Receta::with('usuario')->find($id);

            if (!$receta) {
                return response()->json([
                    'status' => 404,
                    'error' => 'Not Found',
                    'mensaje' => 'No se encontró la receta.'
                ], 404);
            }

            if ($receta->foto) {
                $receta->foto = url('storage/' . $receta->foto);
            }

            return response()->json([
                'status' => 200,
                'mensaje' => 'Receta obtenida correctamente',
                'receta' => $receta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => 'Server Error',
                'mensaje' => 'Error al obtener la receta.'
            ], 500);
        }
    }
}