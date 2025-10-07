<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class EvolutionController extends Controller
{
    /**
     * Exibir a página do Evolution
     */
    public function index()
    {
        return Inertia::render('Dashboard/Evolution/Index', [
            'evolutionUrl' => 'https://sense-evolution-api.lbbcpb.easypanel.host/manager',
            'password' => '429683C4C977415CAAFCCE10F7D57E11'
        ]);
    }
}