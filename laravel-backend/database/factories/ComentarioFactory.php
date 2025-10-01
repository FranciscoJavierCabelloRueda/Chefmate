<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comentario;
use \App\Models\Usuario;
use \App\Models\Receta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaCreacion       = fake()->dateTime();     // Genera una fecha y hora aleatoria para la creación del comentario
        $fechaActualizacion  = fake()->dateTimeBetween($fechaCreacion);     // Genera una fecha aleatoria posterior a la fecha de creación

        return [
            'idUsu'               => Usuario::inRandomOrder()->value('idUsu'),    
            'idRec'               => Receta::inRandomOrder()->value('idRec'),     
            'comentario'          => fake()->paragraph(),    
            'valoracion'          => fake()->numberBetween(1, 5),     
            'fecha_creacion'      => $fechaCreacion,     
            'fecha_actualizacion' => $fechaActualizacion,    
        ];
    }
}
