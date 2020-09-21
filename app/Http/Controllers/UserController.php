<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

// Modelos
use App\Models\User;
use App\Models\Role;
use App\Models\Property;
use App\Http\Resources\User as UserResource;

use DataTables;

class UserController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = User::with('person');
        return DataTables::of($query)->make(true);
    }

    public function show($id)
    {
        $instance = User::with('person', 'roles')->findOrFail($id);
        $userResource = new UserResource($instance);
        return $this->showResponse($userResource);
    }

    public function filters()
    {
        $rolesOptions = Role::all()->map(function($role) {
            return [
                'value' => $role->id,
                'label' => $role->name
            ];
        })->prepend([
            'value' => '',
            'label' => __('all')
        ]);

        $statusOptions = Property::getProperty('userStatus')->prepend([
            'value' => '',
            'label' => __('all')
        ]);

        $filters = [
            'rolesOptions' => $rolesOptions,
            'statusOptions' => $statusOptions
        ];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $rolesOptions = Role::all()->map(function($role) {
            return [
                'value' => $role->id,
                'label' => $role->name
            ];
        });

        $statusOptions = Property::getProperty('userStatus');
        $langsOptions = Property::getProperty('userLangs');

        $moduleData = [
            'status' => $statusOptions,
            'roles' => $rolesOptions,
            'langs' => $langsOptions
        ];

        return $this->showResponse($moduleData);
    }

    public function store(UserRequest $request)
    {
        $instance = User::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(UserRequest $request, $id)
    {
        $instance = User::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = User::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
