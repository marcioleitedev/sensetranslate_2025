<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServicoController;

Route::get('/servicos', [ServicoController::class, 'index']);
