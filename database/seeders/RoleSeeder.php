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
        $permissions = [];
        $permissionInstance = new Permission();

        $modules = $permissionInstance->modules;
        $modulesPermission = $permissionInstance->modulesPermission;
        $permissionsExtra = $permissionInstance->permissionsExtra;

        foreach ($modules as $module) {
            foreach ($modulesPermission as $permission) {
                $permissions[] = $module . ' ' . $permission;
            }
        }

        foreach ($permissionsExtra as $permission) {
            $permissions[] = $permission;
        }

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
