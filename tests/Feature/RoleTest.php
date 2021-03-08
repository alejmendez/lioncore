<?php
namespace App\Tests\Feature;

use App\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    protected function generateData()
    {
        $faker = \Faker\Factory::create();
        return [
            'Name' => $faker->unique()->safeEmail,
        ];
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_create_role()
    {
        $data = $this->generateData();

        $this->json('POST', route('roles.store'), $data)
            ->assertStatus(201)
            ->assertJson([
                'code' => 201,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_update_role()
    {
        $role = Role::factory()->create();

        $data = $this->generateData();

        $this->json('PUT', route('roles.update', $role->id), $data)
            ->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ]);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_show_role()
    {
        $role = Role::factory()->create();

        $this->json('GET', route('roles.show', $role->id))
            ->assertStatus(200);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_delete_role()
    {
        $role = Role::factory()->create();

        $this->json('DELETE', route('roles.destroy', $role->id))
            ->assertStatus(200);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_list_roles()
    {
        Role::factory(2)->create()->map(function ($role) {
            return $role->only(['Name']);
        });

        $this->json('GET', route('roles.index') . '?page=1&rowsPerPage=5')
            ->assertStatus(200)
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'Name'
                    ]
                ],
            ]);
    }
}
