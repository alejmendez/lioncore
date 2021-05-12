<?php

namespace Alejmendez87\Workshop\Generators;

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
            $permission . ' read',
            $permission . ' create',
            $permission . ' update',
            $permission . ' delete'
        ];

        $roleAdmin = Role::findByName('Super Admin', $guardName);
        foreach ($permissions as $permission) {
            PermissionModel::findOrCreate($permission, $guardName);
        }

        $roleAdmin->givePermissionTo($permissions);
    }
}
