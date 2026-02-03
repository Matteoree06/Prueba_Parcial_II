<?php

namespace App\Services;

use App\Models\Producto_Financiero;
use App\DTOs\ProductoDTO;
use App\Repositories\Interfaces\ProductoRepository;

class ProductoService 
{
    private ProductoRepository $productoRepository;

    public function __construct(ProductoRepository $productoRepository) 
    {
        $this->productoRepository = $productoRepository;
    }

    public function getAllProductos() 
    {
        $productos = $this->productoRepository->getAllProductos();
        
        return $productos->map(function($producto) {
            return ProductoDTO::fromModel($producto)->toArray();
        });
    }
}