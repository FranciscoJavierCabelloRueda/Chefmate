<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'     => fake()->name(),    
            'apellidos'  => fake()->lastName(),    
            'email'      => fake()->unique()->safeEmail(),     
            'foto'       => fake()->imageUrl(640, 480, 'people'),     
            'password'   => Hash::make('password'),     
        ];
    }
}
