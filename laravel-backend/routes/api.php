<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\RecetaController;
use App\Http\Controllers\Api\ListaController;
use App\Http\Controllers\Api\ComentarioController;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/usuarios', [UsuarioController::class, 'registrar']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/usuario', [UsuarioController::class, 'obtenerDatos']);
    Route::put('/usuario', [UsuarioController::class, 'actualizar']);
    Route::delete('/usuario', [UsuarioController::class, 'eliminar']);
    Route::get('/usuario/foto', [UsuarioController::class, 'mostrarFoto']);

    Route::get('/recetas', [RecetaController::class, 'listar']);
    Route::get('/recetas/{id}', [RecetaController::class, 'obtener']);

    Route::get('/listas', [ListaController::class, 'listar']);
    Route::post('/listas', [ListaController::class, 'guardar']);
    Route::put('/listas/{id}', [ListaController::class, 'actualizar']);
    Route::delete('/listas/{id}', [ListaController::class, 'eliminar']);

    Route::get('/comentarios/receta/{id}', [ComentarioController::class, 'listar']);
    Route::post('/comentarios', [ComentarioController::class, 'guardar']);
    Route::put('/comentarios/{id}', [ComentarioController::class, 'actualizar']);
    Route::delete('/comentarios/{id}', [ComentarioController::class, 'eliminar']);
});