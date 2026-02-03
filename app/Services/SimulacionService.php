<?php

namespace App\Services;

use App\Models\Simulacion;
use App\Repositories\Interfaces\SimulacionRepository;
use App\DTOs\SimulacionResponseDTO;
use App\DTOs\SimulacionRequestDTO;
use App\Services\UsuarioService;
use App\Services\ProductoService;
use Exception;
use Illuminate\Support\Str;

class SimulacionService 
{
    private SimulacionRepository $simulacionRepository;
    private UsuarioService $usuarioService;
    private ProductoService $productoService;

    public function __construct(
        SimulacionRepository $simulacionRepository, 
        UsuarioService $usuarioService, 
        ProductoService $productoService
    ) {
        $this->simulacionRepository = $simulacionRepository;
        $this->usuarioService = $usuarioService;
        $this->productoService = $productoService;
    }

    public function createSimulacion(array $requestData): array 
    {
        $requestDTO = SimulacionRequestDTO::fromRequest($requestData);
        
        // Validar datos de entrada
        $errors = $requestDTO->validate();
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }

        // Validar que el usuario existe
        $usuarios = $this->usuarioService->getAllUsuarios();
        $usuario = $this->findUsuarioById($usuarios, $requestDTO->usuario_id);
        if (!$usuario) {
            throw new Exception("Usuario no encontrado");
        }

        // Obtener productos disponibles
        $productosDisponibles = $this->productoService->getAllProductos();
        $productosRequest = $requestData['productos'];

        // Verificar si hay productos viables
        $productosViables = $this->filtrarProductosViables($productosRequest, $requestDTO->capital_disponible);
        
        if (empty($productosViables)) {
            return $this->crearRespuestaFondosInsuficientes($requestDTO->capital_disponible, $productosRequest);
        }

        // Optimizar la cartera de inversiones
        $combinacionOptima = $this->optimizarCartera($productosViables, $requestDTO->capital_disponible);

        // Guardar simulación
        $simulacionData = [
            'usuario_id' => $requestDTO->usuario_id,
            'fecha_simulacion' => now(),
            'capital_disponible' => $requestDTO->capital_disponible,
            'ganancia_total' => $combinacionOptima['ganancia_total'],
            'productos_seleccionados' => $combinacionOptima['productos']
        ];

        $simulacion = $this->simulacionRepository->storeSimulacion($simulacionData);

        // Crear respuesta
        return $this->crearRespuestaExitosa($simulacion, $combinacionOptima, $requestDTO->capital_disponible);
    }

    public function getSimulacionesByUsuario(string $usuarioId): array 
    {
        $simulaciones = $this->simulacionRepository->getSimulacionesByUsuarioId($usuarioId);
        
        return $simulaciones->map(function($simulacion) {
            $productos = is_string($simulacion->productos_seleccionados) 
                ? json_decode($simulacion->productos_seleccionados, true) 
                : $simulacion->productos_seleccionados;
                
            $retorno_porcentaje = $simulacion->capital_disponible > 0 
                ? ($simulacion->ganancia_total / $simulacion->capital_disponible) * 100 
                : 0;

            return [
                'id' => $simulacion->id,
                'usuario_id' => $simulacion->usuario_id,
                'fecha_simulacion' => $simulacion->fecha_simulacion,
                'capital_disponible' => $simulacion->capital_disponible,
                'ganancia_total' => $simulacion->ganancia_total,
                'cantidad_productos' => count($productos),
                'retorno_porcentaje' => round($retorno_porcentaje, 2)
            ];
        })->toArray();
    }

    private function findUsuarioById($usuarios, string $usuarioId) 
    {
        foreach ($usuarios as $usuario) {
            if ($usuario['id'] === $usuarioId) {
                return $usuario;
            }
        }
        return null;
    }

    private function filtrarProductosViables(array $productos, float $capital): array 
    {
        return array_filter($productos, function($producto) use ($capital) {
            return $producto['precio'] <= $capital;
        });
    }

    private function optimizarCartera(array $productos, float $capital): array 
    {
        // Ordenar productos por eficiencia (ganancia / precio)
        usort($productos, function($a, $b) {
            $eficienciaA = $a['precio'] > 0 ? ($a['precio'] * $a['porcentaje_ganancia'] / 100) / $a['precio'] : 0;
            $eficienciaB = $b['precio'] > 0 ? ($b['precio'] * $b['porcentaje_ganancia'] / 100) / $b['precio'] : 0;
            return $eficienciaB <=> $eficienciaA;
        });

        $mejorCombinacion = ['productos' => [], 'ganancia_total' => 0, 'costo_total' => 0];
        
        // Algoritmo greedy para optimizar
        $this->buscarMejorCombinacion($productos, $capital, [], 0, 0, $mejorCombinacion);
        
        return $mejorCombinacion;
    }

    private function buscarMejorCombinacion(array $productos, float $capital, array $combinacionActual, float $costoActual, float $gananciaActual, array &$mejorCombinacion): void 
    {
        // Si la ganancia actual es mejor que la mejor encontrada, actualizar
        if ($gananciaActual > $mejorCombinacion['ganancia_total']) {
            $mejorCombinacion = [
                'productos' => $combinacionActual,
                'ganancia_total' => $gananciaActual,
                'costo_total' => $costoActual
            ];
        }

        // Probar agregar cada producto restante
        foreach ($productos as $index => $producto) {
            $nuevoCosto = $costoActual + $producto['precio'];
            
            if ($nuevoCosto <= $capital) {
                $gananciaProducto = $producto['precio'] * ($producto['porcentaje_ganancia'] / 100);
                $nuevaGanancia = $gananciaActual + $gananciaProducto;
                
                $nuevaCombinacion = $combinacionActual;
                $nuevaCombinacion[] = [
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'porcentaje_ganancia' => $producto['porcentaje_ganancia'],
                    'ganancia_esperada' => round($gananciaProducto, 2)
                ];
                
                $productosRestantes = array_slice($productos, $index + 1);
                $this->buscarMejorCombinacion(
                    $productosRestantes, 
                    $capital, 
                    $nuevaCombinacion, 
                    $nuevoCosto, 
                    $nuevaGanancia, 
                    $mejorCombinacion
                );
            }
        }
    }

    private function crearRespuestaFondosInsuficientes(float $capital, array $productos): array 
    {
        $productoMasBarato = min(array_column($productos, 'precio'));
        $diferenciaNecesaria = $productoMasBarato - $capital;

        return [
            'error' => 'Fondos insuficientes',
            'detalle' => "El capital disponible ($$capital) es insuficiente para adquirir cualquier producto de la lista.",
            'capital_disponible' => $capital,
            'producto_mas_barato' => $productoMasBarato,
            'diferencia_necesaria' => $diferenciaNecesaria,
            'recomendacion' => 'Aumente su capital o consulte productos con menor inversión mínima.'
        ];
    }

    private function crearRespuestaExitosa(Simulacion $simulacion, array $combinacion, float $capital): array 
    {
        $costoTotal = $combinacion['costo_total'];
        $capitalRestante = $capital - $costoTotal;
        $retornoPorcentaje = $capital > 0 ? ($combinacion['ganancia_total'] / $capital) * 100 : 0;
        $eficienciaCapital = $capital > 0 ? ($costoTotal / $capital) * 100 : 0;

        $mensaje = $this->generarMensaje($retornoPorcentaje, $eficienciaCapital);

        $respuesta = [
            'id' => $simulacion->id,
            'usuario_id' => $simulacion->usuario_id,
            'fecha_simulacion' => $simulacion->fecha_simulacion,
            'capital_disponible' => $capital,
            'productos_seleccionados' => $combinacion['productos'],
            'costo_total' => $costoTotal,
            'capital_restante' => $capitalRestante,
            'ganancia_total' => round($combinacion['ganancia_total'], 2),
            'retorno_total_porcentaje' => round($retornoPorcentaje, 2),
            'mensaje' => $mensaje
        ];

        // Agregar eficiencia de capital si es relevante
        if ($eficienciaCapital >= 90) {
            $respuesta['eficiencia_capital'] = round($eficienciaCapital, 2);
        }

        return $respuesta;
    }

    private function generarMensaje(float $retornoPorcentaje, float $eficienciaCapital): string 
    {
        if ($eficienciaCapital >= 90) {
            return "Simulación óptima con alta eficiencia de capital (" . round($eficienciaCapital, 0) . "% utilizado)";
        } elseif ($retornoPorcentaje >= 8) {
            return "Simulación exitosa con ganancias óptimas";
        } elseif ($retornoPorcentaje >= 3) {
            return "Simulación con ganancias mínimas. Considere aumentar capital para mejores opciones.";
        } else {
            return "Simulación con bajo retorno. Revise las opciones de inversión disponibles.";
        }
    }
}