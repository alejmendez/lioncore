<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\PropertyRequest;

// Modelos
use App\Models\Property;

use DataTables;

class PropertyController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Property::select('id', 'name', 'value');
        return DataTables::of($query)->make(true);
    }

    public function filters()
    {
        $filters = [];

        return $this->showResponse($filters);
    }

    public function moduleData()
    {
        $moduleData = [];

        return $this->showResponse($moduleData);
    }

    public function show($id)
    {
        $instance = Property::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(PropertyRequest $request)
    {
        $instance = Property::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(PropertyRequest $request, $id)
    {
        $instance = Property::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Property::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
