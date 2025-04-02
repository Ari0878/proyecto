<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AlumnoSeeder extends Seeder
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

        // Generar 2000 registros
        for ($i = 0; $i < 2000; $i++) {
            DB::table('alumno')->insert([
                'matricula' => $faker->numerify('#########'),  // Genera una matrícula con 9 dígitos
                'alumno' => $faker->firstName(),  // Nombre del alumno
                'app' => $faker->lastName(),  // Apellido Paterno
                'apm' => $faker->lastName(),  // Apellido Materno
                'grupo' => 'DSM' . $faker->randomDigitNotNull(),  // Ejemplo: DSM53
                'email' => $faker->unique()->safeEmail(),  // Correo Electrónico
                'fecha_nacimiento' => $faker->date('Y-m-d', '2005-01-01'),  // Fecha de nacimiento
                'sexo' => $faker->randomElement(['Masculino', 'Femenino']),  // Sexo
                'activo' => $faker->boolean(50),  // Activo (50% de probabilidad de ser 0 o 1)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
