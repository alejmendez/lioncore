<?php

namespace Modules\Workshop\Generators;

class Permission extends Generator
{
    protected function generate()
    {
        $permission = strtolower($this->nameModel);

        $permissions = [
            $permission,
            $permission . ' show',
            $permission . ' store',
            $permission . ' update',
            $permission . ' destroy'
        ];

        try {
            Permission::findByName($permission);

            foreach ($permissions as $permission) {
                Permission::create([
                    'name'       => $permission,
                    'guard_name' => 'api'
                ]);
            }

            Role::findByName('admin')->givePermissionTo($permissions);
        } catch (\Maklad\Permission\Exceptions\PermissionAlreadyExists $e) {
            return true;
        } catch (\Maklad\Permission\Exceptions\PermissionDoesNotExist $e) {
            return true;
        }
    }
}
