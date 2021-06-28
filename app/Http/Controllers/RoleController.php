<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Repositories\RoleRepository;
use App\Models\Permission;

class RoleController extends BaseController
{
    use ApiResponse;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->paginate(request()->all());
        return RoleCollection::make($roles);
    }

    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        return RoleResource::make($role);
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

    public function store(RoleRequest $request)
    {
        $role = $this->roleRepository->create($request->all());
        return RoleResource::make($role);
    }

    public function update(RoleRequest $request, $id)
    {
        $role = $this->roleRepository->update($id, $request->all());
        return RoleResource::make($role);
    }

    public function destroy($id)
    {
        $this->roleRepository->destroy($id);
        return $this->deletedResponse();
    }
}
