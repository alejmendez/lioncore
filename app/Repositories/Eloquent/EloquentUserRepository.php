<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Config;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\PersonRepository;
use App\Models\User;
use App\Models\Person;
use App\Repositories\UserRepository;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function __construct($model)
    {
        $this->model = $model;
        $this->personRepository = app(PersonRepository::class);
    }

    public function findByName($userName)
    {
        return $this->model->where('name', $userName)->first();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function create($data)
    {
        $person = $this->personRepository->create($data);
        $data['person_id'] = $person->id;
        $user = $this->model->create($data);
        return $user;
    }
}
