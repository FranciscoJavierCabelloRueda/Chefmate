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
        Schema::create('comentario', function (Blueprint $table) {
            $table->id('idCom');
            $table->text('comentario');
            $table->integer('valoracion');
            $table->dateTime('fecha_creacion'); 
            $table->dateTime('fecha_actualizacion'); 


            // clave foránea con Usuario
            $table->foreignId('idUsu')->nullable()->constrained('usuario', 'idUsu')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
            // clave foránea con Receta
            $table->foreignId('idRec')->nullable()->constrained('receta', 'idRec')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};
