<?php
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\EmployeeRepository;

class CacheEmployeeDecorator extends BaseCacheDecorator implements EmployeeRepository
{
    public function __construct(EmployeeRepository $employee)
    {
        parent::__construct();
        $this->entityName = 'Employee.Employees';
        $this->repository = $employee;
    }
}
