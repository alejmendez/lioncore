<?php

namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    protected function generateData()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $username = Str::slug($firstName) . '.' . Str::slug($lastName) . $this->faker->numberBetween(1, 99999);
        $email    = $username . '@gmail.com';

        $languages = [$this->faker->randomElement(['english', 'spanish', 'french', 'russian', 'german', 'arabic', 'sanskrit'])];
        $contact_options = [$this->faker->randomElement(['email', 'message', 'phone'])];

        return [
            'email'              => $email,
            'role'               => $this->faker->randomElement(['Super Admin', 'writer']),
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

    protected function processData($data)
    {
        $data['email'] = strtolower($data['email']);
        $data['dni'] = (string) $data['dni'];
        $data['languages'] = [$data['languages']];
        $data['contact_options'] = [$data['contact_options']];
        unset($data['password']);
        unset($data['verification_token']);
        return $data;
    }

    protected function getListElementData()
    {
        return [
            'id',
            'displayName',
            'about',
            'photoURL',
            'role',
            'permissions',
            'username',
            'status',
            'person_id',
            'dni',
            'first_name',
            'last_name',
            'full_name',
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
     * @group  user
     * @test
     */
    public function test_can_create_user()
    {
        $data = $this->generateData();
        Log::debug('[test_can_create_user] Data used for user creation: ');
        Log::debug(json_encode($data));

        $response = $this->postJson(route('users.store'), $data);
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
     * @group  user
     * @test
     */
    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $data = $this->generateData();
        Log::debug('[test_can_update_user] User created');
        Log::debug(json_encode($data));

        Log::debug('[test_can_update_user] Data used for user update: ');
        Log::debug(json_encode($data));

        $response = $this->putJson(route('users.update', $user->id), $data);
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_show_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('users.show', $user->id));
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson(route('users.destroy', $user->id));
        $response
            ->assertOk()
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        $this->assertSoftDeleted($user);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_list_users()
    {
        User::factory(2)->create();

        $response = $this->getJson(route('users.index') . '?page=1&rowsPerPage=5');
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
