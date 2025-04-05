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
        Schema::create('detalle', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitud');
            $table->decimal('longitud');
            $table->decimal('altitud');
            $table->string('descripcion');
            $table->text('foto')->nullable();
            $table->string('nombre_parada');
            $table->time('hora_aprox');
            $table->unsignedBigInteger('trayectoria_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle');
    }
};
