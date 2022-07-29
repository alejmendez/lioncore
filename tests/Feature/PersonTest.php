<?php
namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use App\Models\Person;

class PersonTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    protected function generateData()
    {
        return [
            'dni' => $this->faker->numberBetween(5000000, 30000000),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'avatar' => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate' => $this->faker->date('Y-m-d', '-18 years'),
            'room_telephone' => $this->faker->phoneNumber,
            'mobile_phone' => $this->faker->phoneNumber,
            'website' => '',
            'languages' => $this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
            'email' => $this->faker->unique()->safeEmail,
            'nationality' => $this->faker->randomElement(['C', 'E']),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'civil_status' => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options' => $this->faker->randomElement(['email', 'message', 'phone']),
            'address' => $this->faker->address,
            'address2' => $this->faker->secondaryAddress,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'number_children' => $this->faker->numberBetween(0, 5),
            'observation' => $this->faker->text(250),
            'about' => $this->faker->text(250),
            'blood_type' => $this->faker->text(5),
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
            'dni',
            'first_name',
            'last_name',
            'avatar',
            'birthdate',
            'room_telephone',
            'mobile_phone',
            'website',
            'languages',
            'email',
            'nationality',
            'gender',
            'civil_status',
            'contact_options',
            'address',
            'address2',
            'postcode',
            'city',
            'state',
            'country',
            'number_children',
            'observation',
            'about',
            'blood_type',
        ];
    }

    public function test_can_create_person()
    {
        $data = $this->generateData();

        $response = $this->postJson(route('api.v1.people.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_person()
    {
        $person = Person::factory()->create();

        $data = $this->generateData();

        $response = $this->putJson(route('api.v1.people.update', $person->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('people', [
            'dni' => $data['dni'],
        ]);
    }

    public function test_can_fetch_single_person()
    {
        $person = Person::factory()->create();

        $response = $this->getJson(route('api.v1.people.show', $person->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_person()
    {
        $person = Person::factory()->create();

        $response = $this->deleteJson(route('api.v1.people.destroy', $person->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted($person);
    }

    public function test_can_list_people()
    {
        Person::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.people.index') . '?page=1&per_page=5');
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
