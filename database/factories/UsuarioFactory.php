<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
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
            'id' =>Str::uuid(),
            'nombre' =>fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'capital_disponible' => fake()->randomFloat(2, 1000, 10000),
        ];
    }
}
