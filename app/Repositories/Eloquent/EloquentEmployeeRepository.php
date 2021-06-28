<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PersonRepository;

class EloquentEmployeeRepository extends EloquentBaseRepository implements EmployeeRepository
{
    public function __construct($model)
    {
        parent::__construct($model);
        $this->personRepository = app(PersonRepository::class);
    }

    public function getModel()
    {
        return $this->model->with(['person']);
    }

    public function create($data)
    {
        $data = $this->getData($data);
        $person = $this->personRepository->create($data);
        $data['person_id'] = $person->id;
        $employee = $this->model->create($data);
        return $employee;
    }

    public function update($id, $data)
    {
        $data = $this->getData($data);
        $employee = $this->find($id);
        $employee->fill($data);
        $employee->save();

        $this->personRepository->update($employee->person->id, $data);

        $employee = $this->find($id);

        return $employee;
    }
}
