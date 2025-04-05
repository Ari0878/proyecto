<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     *
     * @return void
     */
    public function run()
    {
        // Insertar 20 registros en la tabla 'grupos'
        for ($i = 1; $i <= 20; $i++) {
            DB::table('grupos')->insert([
                'clave' => 'GRP' . str_pad($i, 2, '0', STR_PAD_LEFT), // Genera claves como 'GRP01', 'GRP02', ...
                'nombre' => 'Grupo ' . $i, // Nombre del grupo
                'carrera_id' => rand(1, 4), // Asigna aleatoriamente un 'id_carrera' entre 1 y 10 (asegúrate de tener al menos 10 registros en la tabla 'career')
                'activo' => rand(0, 1), // Activo (0 o 1)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
