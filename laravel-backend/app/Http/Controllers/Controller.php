<?php


/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API ChefMate",
 *     version="1.0",
 *     description="API para gestión de usuarios, recetas, listas y comentarios de ChefMate.",
 *     @OA\Contact(
 *         name="Francisco Javier Cabello Rueda"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Servidor local de desarrollo"
 * )
 * 
 * @OA\Server(
 *     url="http://chefmate-internal.duckdns.org/api",
 *     description="Servidor de producción"
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="sanctum",
 *     description="Token de acceso obtenido en /login"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}