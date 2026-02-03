<?php

namespace App\DTOs;

class ProductoDTO {
    public string $id;
    public string $nombre;
    public string $descripcion;
    public float $costo;
    public float $porcentaje_retorno;
    public bool $activo;

    public function __construct(string $id, string $nombre, string $descripcion, float $costo, float $porcentaje_retorno, bool $activo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->costo = $costo;
        $this->porcentaje_retorno = $porcentaje_retorno;
        $this->activo = $activo;
    }

    public static function fromModel($producto): self {
        return new self(
            $producto->id,
            $producto->nombre,
            $producto->descripcion,
            $producto->costo,
            $producto->porcentaje_retorno,
            $producto->activo
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'costo' => $this->costo,
            'porcentaje_retorno' => $this->porcentaje_retorno,
            'activo' => $this->activo
        ];
    }
    
}