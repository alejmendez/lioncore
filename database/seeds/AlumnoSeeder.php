<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Alumno;
use App\Models\Registro;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i = 0; $i < 3000; $i++) {
            $alumno = factory(Alumno::class)->create();

            $maxIterationRegistro = rand(1, 3);
            for ($j = 0; $j < $maxIterationRegistro; $j++) {
                $registro = factory(Registro::class)->make();
                $registro->alumno_id = $alumno->id;
                $registro->save();
            }
        }
    }
}
