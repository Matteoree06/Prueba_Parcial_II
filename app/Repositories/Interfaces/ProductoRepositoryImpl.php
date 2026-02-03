<?php

namespace App\Repositories\Interfaces;

use App\Models\Producto_Financiero;

class ProductoRepositoryImpl implements ProductoRepository
{
    public function getAllProductos()
    {
        return Producto_Financiero::all();
    }
}