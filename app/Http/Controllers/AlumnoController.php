<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\AlumnoRequest;

// Modelos
use App\Models\Alumno;

use DataTables;

class AlumnoController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Alumno::select('id', 'firstName', 'lastname', 'phone', 'email', 'specialty', 'semester');
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
        $instance = Alumno::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(AlumnoRequest $request)
    {
        $instance = Alumno::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(AlumnoRequest $request, $id)
    {
        $instance = Alumno::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Alumno::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
