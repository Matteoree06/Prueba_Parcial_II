<?php

namespace App\Repositories\Interfaces;

use App\Models\Simulacion;
use Illuminate\Support\Str;

class SimulacionRepositoryImp implements SimulacionRepository 
{
    
    public function storeSimulacion(array $data)
    {
        return Simulacion::create([
            'id' => Str::uuid(),
            'usuario_id' => $data['usuario_id'],
            'fecha_simulacion' => $data['fecha_simulacion'] ?? now(),
            'capital_disponible' => $data['capital_disponible'],
            'ganancia_total' => $data['ganancia_total'],
            'productos_seleccionados' => json_encode($data['productos_seleccionados'])
        ]);
    }

    public function getSimulacionesByUsuarioId(string $usuarioId)
    {
        return Simulacion::where('usuario_id', $usuarioId)
                        ->orderBy('fecha_simulacion', 'desc')
                        ->get();
    }
}