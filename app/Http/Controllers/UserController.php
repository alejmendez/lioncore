<?php

namespace App\Http\Controllers;

// Controllers
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;

// Models
use App\Models\User;
use App\Models\Person;
use App\Models\Role;
use App\Models\Property;

// Repositories
use App\Repositories\UserRepository;

class UserController extends BaseController
{
    use ApiResponse;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->paginate(request()->all());
        return UserCollection::make($users);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return UserResource::make($user);
    }

    public function filters()
    {
        $rolesOptions = Role::all()->map(function ($role) {
            return [
                'value' => $role->name,
                'label' => $role->name
            ];
        })->prepend([
            'value' => '',
            'label' => trans('common.all')
        ]);

        $statusOptions = Property::getProperty('userStatus')->prepend([
            'value' => '',
            'label' => trans('common.all')
        ]);

        $filters = [
            'rolesOptions' => $rolesOptions,
            'statusOptions' => $statusOptions
        ];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $rolesOptions = Role::all()->map(function ($role) {
            return [
                'value' => $role->name,
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
        $user = $this->userRepository->create($request->all());
        return UserResource::make($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userRepository->update($id, $request->all());
        return UserResource::make($user);
    }

    public function destroy($id)
    {
        $user = $this->userRepository->destroy($id);
        return $user;
    }
}
