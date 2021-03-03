<?php

namespace App\Tests\Feature;

use App\Models\User;
use App\Models\Person;

use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    protected function generateData()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $username = $firstName . '.' . $lastName . $this->faker->numberBetween(1, 99999);
        $email    = $username . '@gmail.com';

        $languages = [$this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit'])];
        $contact_options = [$this->faker->randomElement(['email', 'message', 'phone'])];

        return [
            'email'              => $email,
            'role'               => $this->faker->randomElement(['admin', 'writer']),
            'password'           => "12345678",
            'verification_token' => Str::random(64),
            'username'           => $username,
            'status'             => $this->faker->randomElement(['active', 'blocked', 'deactivated']),
            'dni'                => $this->faker->numberBetween(5000000, 30000000),
            'first_name'         => $firstName,
            'last_name'          => $lastName,
            'company'            => $this->faker->company,
            'avatar'             => $this->faker->imageUrl(500, 500, 'people', true, 'Faker'),
            'birthdate'          => $this->faker->date('Y-m-d', '-18 years'),
            'room_telephone'     => $this->faker->phoneNumber,
            'mobile_phone'       => $this->faker->phoneNumber,
            'website'            => $this->faker->url,
            'languages'          => $languages,
            'email'              => $email,
            'nationality'        => $this->faker->randomElement(['C', 'E']),
            'gender'             => $this->faker->randomElement(['male', 'female', 'other']),
            'civil_status'       => $this->faker->randomElement(['C', 'S', 'D', 'V']),
            'contact_options'    => $contact_options,
            'address'            => $this->faker->address,
            'address2'           => $this->faker->secondaryAddress,
            'postcode'           => $this->faker->postcode,
            'city'               => $this->faker->city,
            'state'              => $this->faker->state,
            'country'            => $this->faker->country,
            'number_children'    => $this->faker->numberBetween(0, 5),
            'observation'        => $this->faker->text(250),
            'blood_type'         => $this->faker->randomElement(['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-', 'ARH+', 'BRH+', 'ABRH+', 'ORH+', 'ARH-', 'BRH-', 'ABRH-', 'ORH-']),
        ];
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_create_user()
    {
        $data = $this->generateData();

        $response = $this->json('POST', route('users.store'), $data);
        $response
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => [
                    'email' => strtolower($data['email'])
                ]
            ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $data = $this->generateData();

        $response = $this->json('PUT', route('users.update', $user->id), $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'email' => strtolower($data['email'])
                ]
            ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_show_user()
    {
        $user = User::factory()->create();

        $response = $this->json('GET', route('users.show', $user->id));
        $response
            ->assertStatus(200);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->json('DELETE', route('users.destroy', $user->id));
        $response
            ->assertStatus(200);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_list_users()
    {
        User::factory(2)->create()->map(function ($user) {
            return $user->only(['email']);
        });

        $response = $this->json('GET', route('users.index') . '?page=1&rowsPerPage=5');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'email'
                    ]
                ],
            ]);
    }
}
