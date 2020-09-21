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
use App\Models\Person;
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
                'value' => $role->name,
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
        $data = $request->all();
        $data['languages'] = implode(',', $data['languages']);
        $data['gender'] = implode(',', $data['gender']);
        $data['contact_options'] = implode(',', $data['contact_options']);

        $person = Person::create($data);
        $data['person_id'] = $person->id;
        $user = User::create($data);

        $role = Role::findByName($data['role']);
        $user->assignRole($role);

        $instance = User::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        $data['languages'] = implode(',', $data['languages']);
        $data['contact_options'] = implode(',', $data['contact_options']);

        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();

        $role = Role::findByName($data['role']);
        $user->assignRole($role);

        $person = $user->person;
        $person->fill($data);
        $person->save();

        return $this->showResponse($user);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return $this->deletedResponse();
    }
}
