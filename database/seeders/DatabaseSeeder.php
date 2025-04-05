<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UniversidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Insertar 2 universidades con datos falsos
        DB::table('universidad')->insert([
            [
                'clave' => $faker->word,   // Clave aleatoria
                'nombre' => $faker->company, // Nombre aleatorio de universidad
                'activo' => $faker->boolean, // Activo con valor aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => $faker->word,   // Clave aleatoria
                'nombre' => $faker->company, // Nombre aleatorio de universidad
                'activo' => $faker->boolean, // Activo con valor aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
