<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductoService;

class ProductoController extends Controller
{
    private ProductoService $productoService;

    public function __construct(ProductoService $productoService)
    {
        $this->productoService = $productoService;
    }

    public function getAllProductos()
    {
        try {
            $productos = $this->productoService->getAllProductos();
            return response()->json($productos, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}