<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        app()['cache']->forget('spatie.permission.cache');

        $permissions = [
            'person create',
            'person read',
            'person update',
            'person delete',
            'user create',
            'user read',
            'user update',
            'user delete',
            'role create',
            'role read',
            'role update',
            'role delete',
            'property create',
            'property read',
            'property update',
            'property delete',
            'navigation create',
            'navigation read',
            'navigation update',
            'navigation delete',
            'dashboard read',
            'chat read',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roleAdmin = Role::create([
            'name'       => 'Super Admin',
            'guard_name' => 'api'
        ]);

        Role::create([
            'name'       => 'writer',
            'guard_name' => 'api'
        ]);

        $roleAdmin->givePermissionTo($permissions);
    }
}
