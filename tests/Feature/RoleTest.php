<?php
namespace App\Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;

class RoleTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    public $seed = true;

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
            'permissions' => [],
        ];
    }

    public function test_can_create_role()
    {
        $data = $this->generateData();

        $response = $this->postJson(route('api.v1.roles.store'), $data);
        // $response->dump();
        $response
            ->assertCreated()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_update_role()
    {
        $role = Role::factory()->create();

        $data = $this->generateData();

        $response = $this->putJson(route('api.v1.roles.update', $role->id), $data);
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => $data['name'],
        ]);
    }

    public function test_can_fetch_single_role()
    {
        $role = Role::factory()->create();

        $response = $this->getJson(route('api.v1.roles.show', $role->getRouteKey()));
        // $response->dump();
        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->getListElementData(),
            ]);
    }

    public function test_can_delete_role()
    {
        $role = Role::factory()->create();

        $response = $this->deleteJson(route('api.v1.roles.destroy', $role->getRouteKey()));
        // $response->dump();
        $response->assertOk();

        $this->assertSoftDeleted($role);
    }

    public function test_can_list_roles()
    {
        Role::factory()->times(3)->create();

        $response = $this->getJson(route('api.v1.roles.index') . '?page=1&per_page=5');
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
