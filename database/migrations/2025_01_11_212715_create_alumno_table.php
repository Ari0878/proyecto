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
        Schema::create('alumno', function (Blueprint $table) {
            $table->id('id_alumno'); // Primary key
            $table->string('matricula', 50); // Clave del médico
            $table->string('alumno', 100); // Nombre del alumno
            $table->string('app', 100); // Nombre del alumno
            $table->string('apm', 100); // Nombre del alumno
            $table->string('grupo', 50); // Nombre del grupo
            $table->string('email', 50)->unique(); // Email único, limitado a 25 caracteres
            $table->date('fecha_nacimiento'); // Fecha de nacimiento
            $table->enum('sexo', ['Masculino', 'Femenino']); // Sexo del alumno (solo 'Masculino' o 'Femenino')

            $table->boolean('activo')->default(true); // Campo para indicar si está activo
            
            $table->timestamps(); // Agregar los campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumno');
    }
};
