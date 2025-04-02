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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id('id_grupo'); // Campo de ID
            $table->string('clave')->unique(); // Campo clave
            $table->string('nombre'); // Campo nombre
            $table->unsignedBigInteger('carrera_id'); // Foreign key to universidad
            $table->boolean('activo')->default(true); // Campo para indicar si está activo
            $table->timestamps(); // Campos created_at y updated_at

            // Foreign key constraints
            $table->foreign('carrera_id')
                  ->references('id_carrera')
                  ->on('career') // Cambiado a 'universidad'
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
        Schema::dropIfExists('grupos');
    }
};
