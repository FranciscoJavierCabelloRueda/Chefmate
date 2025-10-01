<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios.
     */
    public function listar()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios-listar', compact('usuarios'));
    }

    /**
     * Actualiza el estado de administrador de un usuario.
     */
    public function actualizar(Request $request, Usuario $usuario)
    {
        // Si el checkbox está marcado, se asigna true, si no, false
        $usuario->admin = $request->has('admin');
        $usuario->save();

        return redirect()->route('usuario.listar')->with('success', __('usuarios.actualizado'));
    }

    /**
     * Elimina un usuario del sistema.
     */
    public function eliminar(Usuario $usuario)
    {
        // Reasignamos las recetas del usuario eliminado al usuario con ID 1 (admin)
        \App\Models\Receta::where('idUsu', $usuario->idUsu)->update(['idUsu' => 1]);

        $usuario->delete();

        return redirect()->route('usuario.listar')->with('success', __('usuarios.eliminado'));
    }
}