<?php

namespace Modules\Core\Repositories\Eloquent;

use Illuminate\Support\Facades\Config;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Core\Models\Person;
use Modules\Core\Repositories\PersonRepository;

class EloquentPersonRepository extends EloquentBaseRepository implements PersonRepository
{
    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
