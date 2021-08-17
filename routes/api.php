<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::apiResource('departamento', 'App\Http\Controllers\DepartamentoController');
    Route::middleware('jwt.auth')->group(function () {
        // Route::
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
        Route::apiResource('usuario', 'App\Http\Controllers\UsuarioController');
        Route::apiResource('mensagem', 'App\Http\Controllers\MensagemController');
    });
});
