<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Receta;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecetaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo'       => fake()->sentence(3, true),    
            'descripcion'  => fake()->paragraph(),     
            'ingredientes' => fake()->paragraphs(3, true), 
            'pasos'        => fake()->paragraphs(5, true), 
            'foto'         => fake()->imageUrl(640, 480, 'food'),                    
            'idUsu'        => Usuario::inRandomOrder()->value('idUsu'), 
        ];
    }
}

