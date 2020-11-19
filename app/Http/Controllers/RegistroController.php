<?php

namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\RegistroRequest;

// Modelos
use App\Models\Registro;

use DataTables;

class RegistroController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Registro::with([
            'alumno' => function ($query) {
                $query->select('firstName', 'lastname', 'semester');
            }
        ])->select('registros.*', 'firstName', 'lastname', 'semester')->where('alumno_id', '26b92204-bffd-4375-976e-df7dbf60b003');

        return DataTables::eloquent($query)->only([
            'id',
            'firstName',
            'lastname',
            'semester',
            'consultancies',
            'documentation',
            'assignedDate',
            'presentation',
            'finalTome'
        ])->toJson();
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
        $instance = Registro::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(RegistroRequest $request)
    {
        $instance = Registro::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(RegistroRequest $request, $id)
    {
        $instance = Registro::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Registro::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
