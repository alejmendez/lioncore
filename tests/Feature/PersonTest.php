<?php

namespace App\Tests\Feature;

use Illuminate\Support\Facades\Log;

use Tests\TestCase;
use App\Models\Person;

class PersonTest extends TestCase
{
    protected function generateData()
    {
        return [
            'dni' => $this->faker->numberBetween(5000000, 30000000),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company' => $this->faker->company,
            'avatar' => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate' => $this->faker->date('Y-m-d', '-18 years'),
            'room_telephone' => $this->faker->phoneNumber,
            'mobile_phone' => $this->faker->phoneNumber,
            'website' => '',
            'languages' => $this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
            'email' => $this->faker->unique()->safeEmail,
            'nationality' => $this->faker->randomElement(['C', 'E']),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'civil_status' => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options' => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'address' => $this->faker->address,
            'address2' => $this->faker->secondaryAddress,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'number_children' => $this->faker->numberBetween(0, 5),
            'observation' => $this->faker->text(250),
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
            'company',
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
            'blood_type'
        ];
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_create_person()
    {
        $data = $this->generateData();
        Log::debug('Data used for person creation: ');
        Log::debug(json_encode($data));

        $response = $this->json('POST', route('person.store'), $data);
        $response
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_update_person()
    {
        $person = Person::factory()->create();

        $data = $this->generateData();
        Log::debug('Person created');
        Log::debug(json_encode($data));

        Log::debug('Data used for person update: ');
        Log::debug(json_encode($data));

        $response = $this->json('PUT', route('person.update', $person->id), $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('people', [
            'dni' => $data['dni'],
        ]);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_show_person()
    {
        $person = Person::factory()->create();

        $response =$this->json('GET', route('person.show', $person->id));
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('people', [
            'dni' => $person->dni,
        ]);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_delete_person()
    {
        $person = Person::factory()->create();

        $response = $this->json('DELETE', route('person.destroy', $person->id));
        $response
            ->assertStatus(200)
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        //$this->assertSoftDeleted($person);
        $this->assertDatabaseMissing('people', [
            'dni' => $person->dni,
        ]);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_list_person()
    {
        Person::factory(2)->create();

        $response = $this->json('GET', route('person.index') . '?page=1&rowsPerPage=5');
        // dd($response);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [$this->getListElementData()],
            ]);
    }
}
