<?php
namespace App\Tests\Feature;

use App\Models\Alumno;
use Tests\TestCase;

class AlumnoTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'firstName' => $faker->firstName,
            'lastname' => $faker->lastName,
            'phone' => $faker->phoneNumber,
            'email' => $faker->unique()->safeEmail,
            'specialty' => $faker->randomElement(['Sistemas', 'Informática', 'Mantenimiento', 'Ambiental']),
            'semester' => $faker->randomElement(['I-2016', 'II-2016', 'I-2017', 'II-2017', 'I-2018', 'II-2018', 'I-2019', 'II-2019', 'I-2020', 'II-2020']),
        ];
    }

    /**
     * @group  alumno
     * @test
     */
    public function test_can_create_alumno()
    {
        $data = $this->generateData();

        $this->json('POST', route('alumnos.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  alumno
     * @test
     */
    public function test_can_update_alumno()
    {
        $alumno = factory(Alumno::class)->create();

        $data = $this->generateData();

        $this->json('PUT', route('alumnos.update', $alumno->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  alumno
     * @test
     */
    public function test_can_show_alumno()
    {
        $alumno = factory(Alumno::class)->create();

        $this->json('GET', route('alumnos.show', $alumno->id))
            ->assertStatus(200);
    }

    /**
     * @group  alumno
     * @test
     */
    public function test_can_delete_alumno()
    {
        $alumno = factory(Alumno::class)->create();

        $this->json('DELETE', route('alumnos.destroy', $alumno->id))
            ->assertStatus(200);
    }

    /**
     * @group  alumno
     * @test
     */
    public function test_can_list_alumnos()
    {
        $alumnos = factory(Alumno::class, 2)->create()->map(function ($alumno) {
            return $alumno->only(['firstName', 'lastname', 'phone', 'email', 'specialty', 'semester']);
        });

        $this->json('GET', route('alumnos.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'firstName', 'lastname', 'phone', 'email', 'specialty', 'semester'
                    ]
                ],
            ]);
    }
}
