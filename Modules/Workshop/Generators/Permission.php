<?php

namespace Modules\Workshop\Generators;

use Modules\Role\Models\Permission as PermissionModel;
use Modules\Role\Models\Role;

class Permission extends Generator
{
    public function generate()
    {
        $permission = strtolower($this->getNameModel());

        $permissions = [
            $permission,
            $permission . ' show',
            $permission . ' store',
            $permission . ' update',
            $permission . ' destroy'
        ];

        try {
            PermissionModel::findByName($permission);
        } catch (\Spatie\Permission\Exceptions\PermissionAlreadyExists $e) {
            return true;
        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
            foreach ($permissions as $permission) {
                PermissionModel::create([
                    'name'       => $permission,
                    'guard_name' => 'api'
                ]);
            }

            Role::findByName('admin')->givePermissionTo($permissions);
        }
    }
}
