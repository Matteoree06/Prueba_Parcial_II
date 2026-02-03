<?php

namespace App\DTOs;

class UsuarioDTO
{
    public string $id;
    public string $nombre;
    public string $email;
    public float $capital_disponible;

    public function __construct(string $id, string $nombre, string $email, float $capital_disponible)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->capital_disponible = $capital_disponible;
    }

    public static function fromModel($usuario): self
    {
        return new self(
            $usuario->id,
            $usuario->nombre,
            $usuario->email,
            $usuario->capital_disponible
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'capital_disponible' => $this->capital_disponible
        ];
    }
}