<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'getUser']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->get('dashboard', function (Request $request) {
    return response()->json(['message' => 'Welcome to the admin dashboard!']);
});
