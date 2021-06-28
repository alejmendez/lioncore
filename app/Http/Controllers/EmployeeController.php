<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use App\Traits\ApiResponse;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;

class EmployeeController extends BaseController
{
    use ApiResponse;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employees = $this->employeeRepository->paginate(request()->all());
        return EmployeeCollection::make($employees);
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->find($id);
        return EmployeeResource::make($employee);
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

    public function store(EmployeeRequest $request)
    {
        $employee = $this->employeeRepository->create($request->all());
        return EmployeeResource::make($employee);
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = $this->employeeRepository->update($id, $request->all());
        return EmployeeResource::make($employee);
    }

    public function destroy($id)
    {
        $this->employeeRepository->destroy($id);
        return $this->deletedResponse();
    }
}
