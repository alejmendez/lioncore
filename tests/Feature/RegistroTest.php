<?php
namespace App\Tests\Feature;

use App\Models\Registro;
use Tests\TestCase;

class RegistroTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'title' => $faker->text,
            'tutor' => $faker->lastName,
            'consultancies' => $faker->randomElement([false, true]),
            'documentation' => $faker->randomElement([false, true]),
            'assignedDate' => $faker->randomElement([false, true]),
            'presentation' => $faker->randomElement([false, true]),
            'finalTome' => $faker->randomElement([false, true]),
                    ];
    }

    /**
     * @group  registro
     * @test
     */
    public function test_can_create_registro()
    {
        $data = $this->generateData();

        $this->json('POST', route('registros.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  registro
     * @test
     */
    public function test_can_update_registro()
    {
        $registro = factory(Registro::class)->create();

        $data = $this->generateData();

        $this->json('PUT', route('registros.update', $registro->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  registro
     * @test
     */
    public function test_can_show_registro()
    {
        $registro = factory(Registro::class)->create();

        $this->json('GET', route('registros.show', $registro->id))
            ->assertStatus(200);
    }

    /**
     * @group  registro
     * @test
     */
    public function test_can_delete_registro()
    {
        $registro = factory(Registro::class)->create();

        $this->json('DELETE', route('registros.destroy', $registro->id))
            ->assertStatus(200);
    }

    /**
     * @group  registro
     * @test
     */
    public function test_can_list_registros()
    {
        $registros = factory(Registro::class, 2)->create()->map(function ($registro) {
            return $registro->only(['title', 'tutor', 'consultancies', 'documentation', 'assignedDate', 'presentation', 'finalTome']);
        });

        $this->json('GET', route('registros.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'title', 'tutor', 'consultancies', 'documentation', 'assignedDate', 'presentation', 'finalTome'
                    ]
                ],
            ]);
    }
}
