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
        $instance = User::with('person')->findOrFail($id);
        $userResource = new UserResource($instance);
        return $this->showResponse($userResource);
    }

    public function filters($id)
    {
        $filters = [

        ];

        return $this->showResponse($filters);
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
