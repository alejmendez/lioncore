<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Role\Models\Permission;
use Modules\Role\Models\Role;

class RoleDatabaseSeeder extends Seeder
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
        $rest = [
            'user',
            'role'
        ];

        foreach ($rest as $r) {
            $permissions[] = $r;
            $permissions[] = $r . ' show';
            $permissions[] = $r . ' store';
            $permissions[] = $r . ' update';
            $permissions[] = $r . ' destroy';
        }

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roleAdmin = Role::create([
            'name'       => 'admin',
            'guard_name' => 'api'
        ]);

        Role::create([
            'name' => 'writer',
            'guard_name' => 'api'
        ]);

        $roleAdmin->givePermissionTo($permissions);

    }
}
