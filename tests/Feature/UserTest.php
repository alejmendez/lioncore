<?php
namespace App\Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Person;

use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
        $userAdmin = factory(User::class)->create();
        $roleAdmin = Role::findByName('admin');
        $userAdmin->assignRole($roleAdmin);
        $this->be($userAdmin);
    }

    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            "person_id" => Person::inRandomOrder()->first()->id,
            "email" => $faker->unique()->safeEmail,
            "password" => "12345678",
            "verification_token" => Str::random(64),
        ];
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_create_user()
    {
        $data = $this->generateData();

        $this->json('POST', route('users.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => [
                    'person_id' => $data['person_id'],
                    'email' => $data['email']
                ]
            ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_update_user()
    {
        $user = factory(User::class)->create();

        $data = $this->generateData();

        $this->json('PUT', route('users.update', $user->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'person_id' => $data['person_id'],
                    'email' => $data['email']
                ]
            ]);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_show_user()
    {
        $user = factory(User::class)->create();

        $this->json('GET', route('users.show', $user->id))
            ->assertStatus(200);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_delete_user()
    {
        $user = factory(User::class)->create();

        $this->json('DELETE', route('users.destroy', $user->id))
            ->assertStatus(200);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_list_users()
    {
        $users = factory(User::class, 2)->create()->map(function ($user) {
            return $user->only(['email']);
        });

        $this->json('GET', route('users.index') . '?page=1&rowsPerPage=5')
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
