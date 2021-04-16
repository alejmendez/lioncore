<?php
namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

use App\Models\Property;

class PropertyTest extends TestCase
{
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
            'value'
        ];
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_create_property()
    {
        $data = $this->generateData();
        Log::debug('[test_can_create_property] Data used for property creation: ');
        Log::debug(json_encode($data));

        $response = $this->postJson(route('properties.store'), $data);
        $response
            ->assertCreated()
            ->assertJson([
                'code' => 201,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
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
        Log::debug('[test_can_update_property] Property created');
        Log::debug(json_encode($data));

        Log::debug('[test_can_update_property] Data used for property update: ');
        Log::debug(json_encode($data));

        $response = $this->putJson(route('properties.update', $property->id), $data);
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('properties', [
            'name' => $data['name'],
        ]);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_show_property()
    {
        $property = Property::factory()->create();

        $response = $this->getJson(route('properties.show', $property->id));
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('properties', [
            'name' => $property->name,
        ]);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_delete_property()
    {
        $property = Property::factory()->create();

        $response = $this->deleteJson(route('properties.destroy', $property->id));
        $response
            ->assertOk()
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        $this->assertSoftDeleted($property);
    }

    /**
     * @group  property
     * @test
     */
    public function test_can_list_properties()
    {
        Property::factory(2)->create();

        $response = $this->getJson(route('properties.index') . '?page=1&rowsPerPage=5');
        // dd($response);
        $response
            ->assertOk()
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [$this->getListElementData()],
            ]);
    }
}
