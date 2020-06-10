<?php

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
        $modules = [
            'user',
            'role'
        ];

        foreach ($modules as $module) {
            $permissions[] = $module;
            $permissions[] = $module . ' show';
            $permissions[] = $module . ' store';
            $permissions[] = $module . ' update';
            $permissions[] = $module . ' destroy';
            $permissions[] = $module . ' module-data';
            $permissions[] = $module . ' filters';
        }

        $permissionsExtra = [];
        foreach ($permissionsExtra as $permission) {
            $permissions[] = $permission;
        }

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roleAdmin = Role::create([
            'name'       => 'admin',
            'guard_name' => 'api'
        ]);

        Role::create([
            'name'       => 'writer',
            'guard_name' => 'api'
        ]);

        $roleAdmin->givePermissionTo($permissions);
    }
}
