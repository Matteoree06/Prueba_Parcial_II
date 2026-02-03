<?php

namespace App\Services;

use App\Models\Usuario;
use App\DTOs\UsuarioDTO;
use App\Repositories\Interfaces\UsuarioRepository;

class UsuarioService 
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) 
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function getAllUsuarios() 
    {
        $usuarios = $this->usuarioRepository->getAllUsuarios();
        
        return $usuarios->map(function($usuario) {
            return UsuarioDTO::fromModel($usuario)->toArray();
        });
    }
}