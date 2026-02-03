<?php

namespace Database\Seeders;

use App\Models\Producto_Financiero;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tabla primero
        Producto_Financiero::truncate();
        
        $productos = [
            [
                'nombre' => 'CDT Tradicional',
                'descripcion' => 'Certificado de Depósito a Término con rentabilidad fija y bajo riesgo.',
                'costo' => 5000.00,
                'porcentaje_retorno' => 8.50
            ],
            [
                'nombre' => 'Fondo de Inversión Conservador',
                'descripcion' => 'Fondo diversificado en renta fija con perfil de riesgo conservador.',
                'costo' => 10000.00,
                'porcentaje_retorno' => 12.25
            ],
            [
                'nombre' => 'Acciones Bancarias',
                'descripcion' => 'Inversión en acciones del sector bancario con dividendos atractivos.',
                'costo' => 15000.00,
                'porcentaje_retorno' => 18.75
            ],
            [
                'nombre' => 'Bonos Corporativos',
                'descripcion' => 'Bonos emitidos por empresas con calificación crediticia alta.',
                'costo' => 25000.00,
                'porcentaje_retorno' => 14.80
            ],
            [
                'nombre' => 'Fondo Inmobiliario',
                'descripcion' => 'Inversión en bienes raíces comerciales y residenciales.',
                'costo' => 50000.00,
                'porcentaje_retorno' => 22.30
            ],
            [
                'nombre' => 'ETF Internacional',
                'descripcion' => 'Fondo cotizado que replica índices internacionales diversificados.',
                'costo' => 20000.00,
                'porcentaje_retorno' => 16.45
            ],
            [
                'nombre' => 'Criptomonedas Estables',
                'descripcion' => 'Inversión en criptomonedas con menor volatilidad y respaldo institucional.',
                'costo' => 8000.00,
                'porcentaje_retorno' => 35.60
            ],
            [
                'nombre' => 'Commodities Oro',
                'descripcion' => 'Inversión en oro físico como refugio de valor ante la inflación.',
                'costo' => 30000.00,
                'porcentaje_retorno' => 11.90
            ]
        ];

        foreach ($productos as $producto) {
            Producto_Financiero::factory()->create($producto);
        }
    }
}
