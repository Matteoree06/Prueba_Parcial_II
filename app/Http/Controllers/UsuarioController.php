<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsuarioService;

class UsuarioController extends Controller
{
    private UsuarioService $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function getAllUsuarios()
    {
    try {
        $usuarios = $this->usuarioService->getAllUsuarios();
        return response()->json($usuarios, 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener usuarios',
            'error' => $e->getMessage()
        ], 500);
    }
    }
}
