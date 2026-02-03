<?php

namespace App\Repositories\Interfaces;

interface SimulacionRepository {

    public function storeSimulacion(array $data);

    public function getSimulacionesByUsuarioId(string $usuarioId);

}