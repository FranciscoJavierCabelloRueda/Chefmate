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
        Schema::create('receta', function (Blueprint $table) {
            $table->id('idRec');
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('ingredientes');
            $table->text('pasos');
            $table->string('foto')->nullable();

            // clave foránea con Usuario
            $table->foreignId('idUsu')->nullable()->constrained('usuario', 'idUsu')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta');
    }
};
