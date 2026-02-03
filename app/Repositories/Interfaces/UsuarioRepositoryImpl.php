<?php

namespace App\Repositories\Interfaces;
use App\Models\Usuario;

class UsuarioRepositoryImpl implements UsuarioRepository {

    public function getAllUsuarios()
    {
        return Usuario::all();
    }

}