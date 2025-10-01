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

class Acceso
{
    /**
     * Middleware para restringir el acceso solo a administradores.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay sesión iniciada, redirige al inicio
        if (!Auth::check()) {
            return to_route('home');
        }
    
        $user = $request->user();
    
        // Si el usuario es admin, continúa
        if ($user->admin == true) {
            return $next($request);
        } else {
            // Si no lo es, cierra sesión y lo lleva a la vista de acceso denegado
            Auth::logout();
            return to_route('denegado');
        }
    }
}