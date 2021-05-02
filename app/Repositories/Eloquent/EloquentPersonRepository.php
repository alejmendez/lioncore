<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Config;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Models\Person;
use App\Repositories\PersonRepository;

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
