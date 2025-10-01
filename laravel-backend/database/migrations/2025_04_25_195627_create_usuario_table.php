<?php

/**
 * curso 2024|25
 * Francisco Javier Cabello Rueda
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('idUsu');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('foto')->nullable();
            $table->string('password');
            $table->boolean('admin')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};