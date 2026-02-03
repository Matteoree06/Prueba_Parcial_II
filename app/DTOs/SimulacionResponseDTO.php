<?php

namespace App\DTOs;

class SimulacionResponseDTO
{
    public string $id;
    public string $usuario_id;
    public string $fecha_simulacion;
    public float $capital_disponible;
    public float $ganancia_total;
    public array $productos_seleccionados;
    public array $detalle_productos;
    public float $porcentaje_ganancia;

    public function __construct(
        string $id,
        string $usuario_id, 
        string $fecha_simulacion,
        float $capital_disponible,
        float $ganancia_total,
        array $productos_seleccionados,
        array $detalle_productos = [],
        float $porcentaje_ganancia = 0.0
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->fecha_simulacion = $fecha_simulacion;
        $this->capital_disponible = $capital_disponible;
        $this->ganancia_total = $ganancia_total;
        $this->productos_seleccionados = $productos_seleccionados;
        $this->detalle_productos = $detalle_productos;
        $this->porcentaje_ganancia = $porcentaje_ganancia;
    }

    public static function fromModel($simulacion, array $detalle_productos = []): self
    {
        $productos_seleccionados = is_string($simulacion->productos_seleccionados) 
            ? json_decode($simulacion->productos_seleccionados, true) 
            : $simulacion->productos_seleccionados;
            
        $porcentaje_ganancia = $simulacion->capital_disponible > 0 
            ? ($simulacion->ganancia_total / $simulacion->capital_disponible) * 100 
            : 0;

        return new self(
            $simulacion->id,
            $simulacion->usuario_id,
            $simulacion->fecha_simulacion,
            $simulacion->capital_disponible,
            $simulacion->ganancia_total,
            $productos_seleccionados,
            $detalle_productos,
            $porcentaje_ganancia
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'fecha_simulacion' => $this->fecha_simulacion,
            'capital_disponible' => $this->capital_disponible,
            'ganancia_total' => $this->ganancia_total,
            'porcentaje_ganancia' => round($this->porcentaje_ganancia, 2),
            'productos_seleccionados' => $this->productos_seleccionados,
            'detalle_productos' => $this->detalle_productos
        ];
    }
}