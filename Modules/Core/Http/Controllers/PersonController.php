<?php
namespace Modules\core\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use Modules\core\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use Modules\core\Http\Request\PersonRequest;

// Modelos
use Modules\core\Models\Person;

use DataTables;

class PersonController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        return DataTables::of(Person::query())->make(true);
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
