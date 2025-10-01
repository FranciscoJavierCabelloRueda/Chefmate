<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // creamos usuarios
        $this->call([ UsuarioTableSeeder::class, ]) ;

        // creamos usuarios aleatorios
        \App\Models\Usuario::factory(8)->create();

        // creamos recetas 
        $this->call([ RecetaTableSeeder::class, ]) ;

        // creamos comentarios aleatorios
        \App\Models\Comentario::factory(10)->create() ;

        // creamos listas aleatorias
        \App\Models\Lista::factory(10)->create() ;

        // creamos Lista_recetas
        $this->call([ ListaRecetaTableSeeder::class, ]) ;

    }
}
