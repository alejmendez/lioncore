<?php
namespace Modules\User\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use Modules\core\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use Modules\User\Http\Request\UserRequest;

// Modelos
use Modules\User\Models\User;

use DataTables;

class UserController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        return DataTables::of(User::query())->make(true);
    }

    public function show($id)
    {
        $instance = User::findOrFail($id);
        return $this->showResponse($instance);
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
