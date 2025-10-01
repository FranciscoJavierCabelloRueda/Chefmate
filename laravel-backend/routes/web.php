<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

use App\Http\Controllers\Auth\AuthenticatedSessionController ;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Depends;

use App\Http\Controllers\DepartamentoController ;
use App\Http\Controllers\UsuarioController ;
use App\Http\Controllers\RecetaController ;

Route::view('denegado','link.denegado')->name('denegado') ;

Route::middleware('redireccion')->group(function() {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('home') ;
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login') ;
}) ;

Route::group([  'middleware' => 'acceso',
                'prefix' => 'admin'], function()
{
    Route::group([ 'as' => 'inicio.'], function()
    {
        Route::view('/', 'admin.index')->name('main') ;
    }) ;

    Route::group([  'prefix' => 'receta',
                    'as' => 'receta.'], function()
    {
        Route::get('/', [ RecetaController::class, 'listar' ])->name('listar') ;
        Route::get('/crear', [RecetaController::class, 'crear'])->name('crear');
        Route::post('/guardar', [RecetaController::class, 'guardar'])->name('guardar');
        Route::get('/{receta}/editar', [RecetaController::class, 'editar'])->name('editar');
        Route::put('/{receta}', [RecetaController::class, 'actualizar'])->name('actualizar');
        Route::delete('/{receta}', [RecetaController::class, 'eliminar'])->name('eliminar');
    }) ;

    Route::group(['prefix' => 'usuario', 'as' => 'usuario.'], function () {
        Route::get('/', [UsuarioController::class, 'listar'])->name('listar');
        Route::put('/{usuario}', [UsuarioController::class, 'actualizar'])->name('actualizar');
        Route::delete('/{usuario}', [UsuarioController::class, 'eliminar'])->name('eliminar');
    });
}) ;

require __DIR__.'/auth.php';
