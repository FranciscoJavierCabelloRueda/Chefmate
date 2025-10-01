<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () 
{
       Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

