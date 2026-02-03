<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SimulacionService;

class SimulacionController extends Controller
{
    private SimulacionService $simulacionService;

    public function __construct(SimulacionService $simulacionService)
    {
        $this->simulacionService = $simulacionService;
    }

    public function store()
    {
        //
    }

    public function show($id)
    {
        //
    }
}
