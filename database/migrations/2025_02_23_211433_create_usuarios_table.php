<?php

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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('correo')->unique();
            $table->string('PASSWORD');
            $table->string('matricula')->unique();
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->boolean('activo')->default(true);
            $table->unsignedBigInteger('rol_id');
            $table->string('reset_code')->nullable();
            $table->timestamp('reset_code_expiry')->nullable();
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
