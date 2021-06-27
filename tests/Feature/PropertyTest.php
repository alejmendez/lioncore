<?php
namespace App\Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\Property;

class PropertyTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function generateData()
    {
        $property = $this->faker->unique()->word . $this->faker->numberBetween(1, 999999);
        return [
            'name' => $property,
            'value' => $property,
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
            'name',
            'value',
        ];
    }

    public function test_can_create_property()
    {
        $data = $this->generateData();

        $response = $this->postJson(route('api.v1.properties.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_property()
    {
        $property = Property::factory()->create();

        $data = $this->generateData();

        $response = $this->putJson(route('api.v1.properties.update', $property->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('properties', [
            'name' => $data['name'],
        ]);
    }

    public function test_can_fetch_single_property()
    {
        $property = Property::factory()->create();

        $response = $this->getJson(route('api.v1.properties.show', $property->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_property()
    {
        $property = Property::factory()->create();

        $response = $this->deleteJson(route('api.v1.properties.destroy', $property->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted($property);
    }

    public function test_can_list_properties()
    {
        Property::factory()->times(3)->create();

        $response = $this->getJson(route('api.v1.properties.index') . '?page=1&per_page=5');
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'self',
                'links',
                'meta',
                'data' => [$this->getListElementData()],
            ]);
    }
}
