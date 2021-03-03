<?php

namespace App\Tests\Feature;

use App\Models\Person;
use App\Models\User;
use Tests\TestCase;

class PersonTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'dni' => $faker->numberBetween(5000000, 30000000),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'company' => $faker->company,
            'avatar' => $faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate' => $faker->date('Y-m-d', '-18 years'),
            'room_telephone' => $faker->phoneNumber,
            'mobile_phone' => $faker->phoneNumber,
            'website' => '',
            'languages' => $faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit']),
            'email' => $faker->unique()->safeEmail,
            'nationality' => $faker->randomElement(['C', 'E']),
            'gender' => $faker->randomElement(['M', 'F']),
            'civil_status' => $faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options' => $faker->randomElement(['C', 'S', 'D', 'V']),
            'address' => $faker->address,
            'address2' => $faker->secondaryAddress,
            'postcode' => $faker->postcode,
            'city' => $faker->city,
            'state' => $faker->state,
            'country' => $faker->country,
            'number_children' => $faker->numberBetween(0, 5),
            'observation' => $faker->text(250),
            'blood_type' => $faker->text(5),
        ];
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_create_person()
    {
        $data = $this->generateData();
        $response = $this->json('POST', route('person.store'), $data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
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

        $this->json('PUT', route('person.update', $person->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_show_person()
    {
        $person = Person::factory()->create();

        $this->json('GET', route('person.show', $person->id))
            ->assertStatus(200);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_delete_person()
    {
        $person = Person::factory()->create();

        $this->json('DELETE', route('person.destroy', $person->id))
            ->assertStatus(200);
    }

    /**
     * @group  person
     * @test
     */
    public function test_can_list_person()
    {
        $person = Person::factory(2)->create()->map(function ($person) {
            return $person->only(['dni', 'first_name', 'last_name']);
        });

        $this->json('GET', route('person.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'dni', 'first_name', 'last_name'
                    ]
                ],
            ]);
    }
}
