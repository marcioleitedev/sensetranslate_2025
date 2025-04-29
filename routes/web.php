<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ROTAS PÚBLICAS
Route::get('/', fn() => Inertia::render('Home/Index'));
Route::get('/contato', fn() => Inertia::render('Contato/Index'));
Route::get('/empresa', fn() => Inertia::render('Empresa/Index'));
Route::get('/localizacao', fn() => Inertia::render('Localizacao/Index'));
Route::get('/servicos', fn() => Inertia::render('Servicos/Index'));
Route::get('/login', fn() => Inertia::render('Login/Index'));

// ROTAS PROTEGIDAS (DASHBOARD)
Route::prefix('dashboard')->group(function () {
    Route::get('/', fn() => Inertia::render('Dashboard/Home/Index'));
    Route::get('/usuarios', fn() => Inertia::render('Dashboard/Usuarios/Index'));
    Route::get('/usuarios/create', fn() => Inertia::render('Dashboard/Usuarios/Create'));
    Route::get('/usuarios/edit/{id}', fn($id) => Inertia::render('Dashboard/Usuarios/Edit', ['id' => $id]));
    // Adicione mais rotas conforme sua necessidade

    // Rota de Orçamentos
    Route::get('/orcamentos', fn() => Inertia::render('Dashboard/Orcamentos/Index'));

    // Rota de Serviços
    Route::get('/servicos', fn() => Inertia::render('Dashboard/Servicos/Index'));

    Route::get('/arvore/{id}', fn($id) => Inertia::render('Dashboard/Arvore/Index',  ['id' => $id]));

    Route::get('/pdf/{id}', fn($id) => Inertia::render('Dashboard/Arvore_pdf/Index',  ['id' => $id]));
});
