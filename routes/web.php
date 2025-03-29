<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/{page?}', function ($page = 'Home') {
    return Inertia::render(ucfirst($page));
})->where('page', '.*'); // Permite URLs dinâmicas