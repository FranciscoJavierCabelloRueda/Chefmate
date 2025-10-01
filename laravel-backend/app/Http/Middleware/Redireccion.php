<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Redireccion
{
    /**
     * Middleware que evita que usuarios autenticados accedan a rutas como login o registro.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está logueado, dejamos que continúe
        if (!Auth::check()) return $next($request);

        // Si ya está logueado, lo mandamos a la página principal
        return to_route('inicio.main');
    }
}