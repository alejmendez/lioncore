<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

// Modelos
use App\Models\Role;
use App\Models\Permission;

use DataTables;

class RoleController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Role::select('id', 'name');
        return DataTables::of($query)->make(true);
    }

    public function filters()
    {
        $filters = [];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $permissions = [];
        $permissionsDb = Permission::select('id', 'name')
            ->distinct('name')
            ->orderBy('name')
            ->get();

        foreach($permissionsDb as $permission) {
            $explode = explode(' ', trim($permission->name));
            $module = array_shift($explode);
            $permission->displayName = implode(' ', $explode);
            if (!isset($permissions[$module])) {
                $permissions[$module] = [];
            }
            $permissions[$module][] = $permission;
        }

        $moduleData = [
            'permissions' => $permissions
        ];

        return $this->showResponse($moduleData);
    }

    public function show($id)
    {
        $instance = Role::with('permissions')->findOrFail($id)->toArray();
        $permissions = [];
        foreach ($instance['permissions'] as $permission) {
            $permissions[] = $permission['id'];
        }
        $instance['permissions'] = $permissions;

        return $this->showResponse($instance);
    }

    public function store(RoleRequest $request)
    {
        $instance = Role::create([
            'name' => $request->name
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $instance->syncPermissions($permissions);

        return $this->createdResponse($instance);
    }

    public function update(RoleRequest $request, $id)
    {
        $instance = Role::findOrFail($id);
        $instance->name = $request->name;
        $instance->save();

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $instance->syncPermissions($permissions);

        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Role::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
