<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('usuarios')->group(function () {
    Route::get('/', [\App\Http\Controllers\UsuarioController::class, 'getAllUsuarios']);
});

Route::prefix('simulaciones')->group(function () {
    Route::post('/', [\App\Http\Controllers\SimulacionController::class, 'store']);
    Route::get('/{id}', [\App\Http\Controllers\SimulacionController::class, 'show']);
});

Route::prefix('productos')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProductoController::class, 'getAllProductos']);
});