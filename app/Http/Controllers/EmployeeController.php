<?php
namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;

// Modelos
use App\Models\Employee;

class EmployeeController extends BaseController
{
    use ApiResponse;

    public function index()
    {
        $query = Employee::select('id', 'code', 'position', 'group_id', 'date_admission', 'salary');
        return datatables()->of($query)->make(true);
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
        $instance = Employee::findOrFail($id);
        return $this->showResponse($instance);
    }

    public function store(EmployeeRequest $request)
    {
        $instance = Employee::create($request->all());
        return $this->createdResponse($instance);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $instance = Employee::findOrFail($id);
        $instance->fill($request->all());
        $instance->save();
        return $this->showResponse($instance);
    }

    public function destroy($id)
    {
        $instance = Employee::findOrFail($id);
        $instance->delete();
        return $this->deletedResponse();
    }
}
