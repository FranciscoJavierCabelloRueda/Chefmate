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
        Schema::create('lista', function (Blueprint $table) {
            $table->id('idLis');
            $table->string('nombre_lista');

            // clave foránea con Usuario
            $table->foreignId('idUsu')->nullable()->constrained('usuario', 'idUsu')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista');
    }
};
