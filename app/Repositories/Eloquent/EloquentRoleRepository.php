<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\RoleRepository;

use App\Models\Permission;

class EloquentRoleRepository extends EloquentBaseRepository implements RoleRepository
{
    public function getModel()
    {
        return $this->model->with(['permissions']);
    }

    public function create($data)
    {
        $data = $this->getData($data);
        $role = $this->getModel()->create([
            'name' => $data['name']
        ]);

        $permissions = Permission::whereIn('id', $data['permissions'])->get();
        $role->syncPermissions($permissions);

        return $role;
    }

    public function update($id, $data)
    {
        $data = $this->getData($data);

        $role = $this->find($id);
        $role->name = $data['name'];
        $role->save();

        $permissions = Permission::whereIn('id', $data['permissions'])->get();
        $role->syncPermissions($permissions);
        return $role;
    }

}
