<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career', function (Blueprint $table) {
            $table->id('id_carrera'); // Campo de ID
            $table->string('clave')->unique(); // Campo clave
            $table->string('nombre'); // Campo nombre
            $table->unsignedBigInteger('universidad_id'); // Foreign key to universidad
            $table->boolean('activo')->default(true); // Campo para indicar si está activo
            $table->timestamps(); // Campos created_at y updated_at

            // Foreign key constraints
            $table->foreign('universidad_id')
                  ->references('id_uni')
                  ->on('universidad') // Cambiado a 'universidad'
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career');
    }
};
