<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialAuthController;

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'getUser']);
Route::post('logout', [AuthController::class, 'logout']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback']);

Route::controller(UsuariosController::class)->prefix('usuarios')->group(function () {
    Route::get('/', 'index');
});
