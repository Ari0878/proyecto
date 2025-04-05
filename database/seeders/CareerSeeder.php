<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una instancia de Faker
        $faker = Faker::create();

        // Insertar 4 registros con datos falsos
        for ($i = 0; $i < 4; $i++) {
            DB::table('career')->insert([
                'clave' => $faker->unique()->bothify('CAR##'), // Genera claves como CAR01, CAR02
                'nombre' => $faker->sentence(3), // Genera un nombre de carrera con 3 palabras
                'universidad_id' => $faker->numberBetween(1, 2), // ID de universidad aleatorio
                'activo' => $faker->boolean(80), // 80% de probabilidad de ser activo
            ]);
        }
    }
}
