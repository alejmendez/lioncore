<?php
namespace Modules\User\Tests\Feature;

use Modules\User\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'person_id' => $faker->number,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => $faker->datetimestamp,
            'password' => $faker->randomElement(['M', 'F']),
            'verification_token' => $faker->numberBetween(150, 210),
                    ];
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_create_user()
    {
        $data = $this->generateData();

        $this->post(route('user.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_update_user()
    {
        $user = factory(User::class)->create();

        $data = $this->generateData();

        $this->put(route('user.update', $user->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_show_user()
    {
        $user = factory(User::class)->create();

        $this->get(route('user.show', $user->id))
            ->assertStatus(200);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_delete_user()
    {
        $user = factory(User::class)->create();

        $this->delete(route('user.destroy', $user->id))
            ->assertStatus(204);
    }

    /**
     * @group  user
     * @test
     */
    public function test_can_list_users()
    {
        $users = factory(User::class, 2)->create()->map(function ($user) {
            return $user->only([]);
        });

        $this->get(route('user.index'))
            ->assertStatus(200)
            ->assertJson($users->toArray())
            ->assertJsonStructure([
                '*' => [],
            ]);
    }
}
