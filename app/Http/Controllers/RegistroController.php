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
use App\Models\Alumno;

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
        ])->select('registros.*', 'firstName', 'lastname', 'semester');

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
        $moduleData = [
            'alumnos' => Alumno::select('id', 'firstName', 'lastname', 'semester')
                ->orderBy('firstName')
                ->orderBy('lastname')
                ->get()
                ->map(function ($alumno) {
                return [
                    'value' => $alumno->id,
                    'label' => $alumno->firstName . ' ' . $alumno->lastname . ' (' . $alumno->semester . ')'
                ];
            })
        ];

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
