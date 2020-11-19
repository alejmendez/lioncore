<?php
namespace App\Tests\Feature;

use App\Models\Grafica;
use Tests\TestCase;

class GraficaTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'title' => $faker->text,
                    ];
    }

    /**
     * @group  grafica
     * @test
     */
    public function test_can_create_grafica()
    {
        $data = $this->generateData();

        $this->json('POST', route('graficas.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  grafica
     * @test
     */
    public function test_can_update_grafica()
    {
        $grafica = factory(Grafica::class)->create();

        $data = $this->generateData();

        $this->json('PUT', route('graficas.update', $grafica->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  grafica
     * @test
     */
    public function test_can_show_grafica()
    {
        $grafica = factory(Grafica::class)->create();

        $this->json('GET', route('graficas.show', $grafica->id))
            ->assertStatus(200);
    }

    /**
     * @group  grafica
     * @test
     */
    public function test_can_delete_grafica()
    {
        $grafica = factory(Grafica::class)->create();

        $this->json('DELETE', route('graficas.destroy', $grafica->id))
            ->assertStatus(200);
    }

    /**
     * @group  grafica
     * @test
     */
    public function test_can_list_graficas()
    {
        $graficas = factory(Grafica::class, 2)->create()->map(function ($grafica) {
            return $grafica->only(['title']);
        });

        $this->json('GET', route('graficas.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'title'
                    ]
                ],
            ]);
    }
}
