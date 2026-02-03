<?php

namespace App\DTOs;

class SimulacionRequestDTO
{
    public string $usuario_id;
    public float $capital_disponible;
    public array $productos_seleccionados;

    public function __construct(string $usuario_id, float $capital_disponible, array $productos_seleccionados)
    {
        $this->usuario_id = $usuario_id;
        $this->capital_disponible = $capital_disponible;
        $this->productos_seleccionados = $productos_seleccionados;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['usuario_id'],
            $data['capital_disponible'],
            $data['productos_seleccionados'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'usuario_id' => $this->usuario_id,
            'capital_disponible' => $this->capital_disponible,
            'productos_seleccionados' => $this->productos_seleccionados
        ];
    }

    public function validate(): array
    {
        $errors = [];
        
        if (empty($this->usuario_id)) {
            $errors[] = 'El usuario_id es requerido';
        }
        
        if ($this->capital_disponible <= 0) {
            $errors[] = 'El capital disponible debe ser mayor a 0';
        }
        
        if (empty($this->productos_seleccionados)) {
            $errors[] = 'Debe seleccionar al menos un producto';
        }
        
        return $errors;
    }
}