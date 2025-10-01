<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ListaRecetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inicializamos un array vacío para almacenar los registros
        $datos = [];

        // Creamos una instancia de Faker para generar datos ficticios
        $faker = Faker::create();

        // Generamos 10 registros aleatorios
        for ($total = 0; $total < 20; $total++):
            // Por cada iteración, añadimos un nuevo par de IDs al array
            // 'idLis' e 'idRec' entre 1 y 10
            array_push(
                $datos,
                [
                    'idLis' => $faker->numberBetween(1, 10),  // ID de lista aleatorio
                    'idRec' => $faker->numberBetween(1, 12)   // ID de receta aleatorio
                ]
            );
        endfor;

        // Insertamos todos los registros generados en la tabla 'lista_receta'
        DB::table('lista_receta')->insert($datos);
    }
}
