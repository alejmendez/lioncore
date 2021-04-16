<?php

namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;

class RoleTest extends TestCase
{
    protected function generateData()
    {

        $permissions = Permission::all()->map(function ($permission) {
            return $permission->id;
        });

        $len = $this->faker->numberBetween(1, 5);
        $permissionsArr = [];
        for ($i = 0; $i < $len; $i++) {
            $permissionsArr[] = $this->faker->randomElement($permissions);
        }

        return [
            'name' => Str::random(8),
            'permissions' => $permissionsArr,
        ];
    }

    protected function getListElementData()
    {
        return [
            'id',
            'name',
            'guard_name',
            'permissions' => [],
        ];
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_create_role()
    {
        $data = $this->generateData();
        Log::debug('[test_can_create_role] Data used for role creation: ');
        Log::debug(json_encode($data));

        $response = $this->postJson(route('roles.store'), $data);
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
     * @group  role
     * @test
     */
    public function test_can_update_role()
    {
        $role = Role::factory()->create();

        $data = $this->generateData();
        Log::debug('[test_can_update_role] Role created');
        Log::debug(json_encode($data));

        Log::debug('[test_can_update_role] Data used for role update: ');
        Log::debug(json_encode($data));

        $response = $this->putJson(route('roles.update', $role->id), $data);
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_show_role()
    {
        $role = Role::factory()->create();

        $response = $this->getJson(route('roles.show', $role->id));
        $response
            ->assertOk()
            ->assertJson([
                'code' => 200,
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => $role->name,
        ]);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_delete_role()
    {
        $role = Role::factory()->create();

        $response = $this->deleteJson(route('roles.destroy', $role->id));
        $response
            ->assertOk()
            ->assertJson([
                'code'    => 200,
                'status'  => 'success',
                'data'    => 'Resource deleted',
                'message' => 'Deleted'
            ]);

        $this->assertSoftDeleted($role);
    }

    /**
     * @group  role
     * @test
     */
    public function test_can_list_roles()
    {
        Role::factory(2)->create();

        $response = $this->getJson(route('roles.index') . '?page=1&rowsPerPage=5');
        //dd($response);
        $response
            ->assertOk()
            ->assertJsonStructure([
                'draw',
                'recordsTotal',
                'recordsFiltered',
                'data' => [
                    [
                        'id',
                        'name'
                    ]
                ],
            ]);
    }
}
