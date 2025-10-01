<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Creamos el usuario administrador
        Usuario::create([
            'idUsu' => '1',
            'nombre' => 'Francisco Javier',
            'apellidos' => 'Cabello Rueda',
            'email' => 'admin@chefmate.com',
            'password' => Hash::make('password'),
            'admin' => true,
        ]);

        // Creamos un usuario estándar
        Usuario::create([
            'idUsu' => '2',
            'nombre' => 'Manuel',
            'apellidos' => 'García López',
            'email' => 'manuel@chefmate.com',
            'password' => Hash::make('password'),
        ]);
    }
}
