<?php
namespace App\Tests\Feature;

use App\Models\Property;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->unique()->word,
            'value' => $faker->unique()->word,
        ];
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_create_property()
    {
        $data = $this->generateData();

        $this->json('POST', route('properties.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_update_property()
    {
        $property = Property::factory()->create();

        $data = $this->generateData();

        $this->json('PUT', route('properties.update', $property->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_show_property()
    {
        $property = Property::factory()->create();

        $this->json('GET', route('properties.show', $property->id))
            ->assertStatus(200);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_delete_property()
    {
        $property = Property::factory()->create();

        $this->json('DELETE', route('properties.destroy', $property->id))
            ->assertStatus(200);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_list_properties()
    {
        Property::factory(2)->create()->map(function ($property) {
            return $property->only(['name', 'value']);
        });

        $this->json('GET', route('properties.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'name', 'value'
                    ]
                ],
            ]);
    }
}
