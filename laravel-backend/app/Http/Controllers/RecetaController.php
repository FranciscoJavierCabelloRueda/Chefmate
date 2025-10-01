<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecetaController extends Controller
{
    /**
     * Muestra la vista con el listado de todas las recetas.
     */
    public function listar(Request $request)
    {
        return view('admin.recetas-listar', ['receta' => Receta::all()]);
    }

    /**
     * Muestra el formulario para crear una nueva receta.
     */
    public function crear()
    {
        return view('admin.recetas-crear');
    }

    /**
     * Guarda una nueva receta en la base de datos.
     */
    public function guardar(Request $request)
    {
        // Validamos los datos del formulario
        $validated = $request->validate([
            'titulo'       => 'required|string|min:5|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
            'ingredientes' => 'required|string|min:10',
            'pasos'        => 'required|string|min:10',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        // Si se sube una imagen, la guardamos
        if ($request->hasFile('foto')) {
            $ruta = $request->file('foto')->store('recetas', 'public');
            $validated['foto'] = $ruta;
        } else {
            $validated['foto'] = null; // Para evitar errores si no se sube imagen
        }

        // Asignar el ID del usuario autenticado
        $validated['idUsu'] = auth()->id();

        // Creamos la receta con los datos validados
        Receta::create($validated);

        return redirect()->route('receta.listar')->with('success', __('recetas.creada'));
    }

    /**
     * Muestra el formulario para editar una receta existente.
     */
    public function editar(Receta $receta)
    {
        return view('admin.recetas-editar', compact('receta'));
    }

    /**
     * Actualiza una receta existente.
     */
    public function actualizar(Request $request, Receta $receta)
    {
        // Validamos los datos recibidos
        $validated = $request->validate([
            'titulo'       => 'required|string|min:5|max:255',
            'descripcion'  => 'required|string|min:10|max:1000',
            'ingredientes' => 'required|string|min:10',
            'pasos'        => 'required|string|min:10',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        // Si se sube una nueva imagen, reemplazamos la anterior
        if ($request->hasFile('foto')) {
            if ($receta->foto) {
                Storage::disk('public')->delete($receta->foto);
            }
            $ruta = $request->file('foto')->store('recetas', 'public');
            $validated['foto'] = $ruta;
        }

        // Actualizamos la receta
        $receta->update($validated);

        return redirect()->route('receta.listar')->with('success', __('recetas.actualizada'));
    }

    /**
     * Elimina una receta.
     */
    public function eliminar(Receta $receta)
    {
        $receta->delete();

        return redirect()->route('receta.listar')->with('success', __('recetas.eliminada'));
    }
}