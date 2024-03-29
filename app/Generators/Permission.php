<?php

namespace App\Generators;

use App\Models\Permission as PermissionModel;
use App\Models\Role;

class Permission extends Generator
{
    public function generate()
    {
        app()['cache']->forget('spatie.permission.cache');
        $permission = strtolower($this->getNameModel());
        $guardName = 'api';

        $permissions = [
            $permission,
            $permission . ' show',
            $permission . ' store',
            $permission . ' update',
            $permission . ' destroy'
        ];

        $roleAdmin = Role::findByName('admin', $guardName);
        foreach ($permissions as $permission) {
            PermissionModel::findOrCreate($permission, $guardName);
        }

        $roleAdmin->givePermissionTo($permissions);
    }
}
