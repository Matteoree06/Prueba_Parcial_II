<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tabla primero
        Usuario::truncate();
        
        // Crear 5 usuarios
        Usuario::factory()->create([
            'nombre' => 'Juan Carlos Pérez',
            'email' => 'juan.perez@email.com',
            'capital_disponible' => 75000.00
        ]);

        Usuario::factory()->create([
            'nombre' => 'María Elena García',
            'email' => 'maria.garcia@email.com', 
            'capital_disponible' => 120000.00
        ]);

        Usuario::factory()->create([
            'nombre' => 'Carlos Roberto López',
            'email' => 'carlos.lopez@email.com',
            'capital_disponible' => 95000.00
        ]);

        Usuario::factory()->create([
            'nombre' => 'Ana Sofia Martínez',
            'email' => 'ana.martinez@email.com',
            'capital_disponible' => 180000.00
        ]);

        Usuario::factory()->create([
            'nombre' => 'Luis Fernando Torres',
            'email' => 'luis.torres@email.com',
            'capital_disponible' => 65000.00
        ]);
    }
}
