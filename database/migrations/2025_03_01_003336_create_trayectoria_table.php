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
        Schema::create('trayectoria', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio');
            $table->string('ruta_inicio');
            $table->string('ruta_final');
            $table->time('hora_final');
            $table->unsignedBigInteger('vehiculo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trayectoria');
    }
};
