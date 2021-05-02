<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\PersonRequest;

// Modelos
use App\Models\Person;

class PersonController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Person::query();
        return datatables()->of($query)->make(true);
    }

    public function show($id)
    {
        $instance = Person::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(PersonRequest $request)
    {
        $instance = Person::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(PersonRequest $request, $id)
    {
        $instance = Person::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Person::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
