<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;

use App\Models\Role;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function __construct($model)
    {
        parent::__construct($model);
        $this->personRepository = app(PersonRepository::class);
    }

    public function getModel()
    {
        return $this->model->with(['person', 'roles']);
    }

    public function create($data)
    {
        $person = $this->personRepository->create($data);
        $data['person_id'] = $person->id;
        $user = $this->model->create($data);
        return $user;
    }

    public function update($id, $data)
    {
        $user = $this->find($id);
        $user->fill($data);
        $user->save();

        $role = Role::findByName($data['role']);
        $user->assignRole($role);

        $this->personRepository->update($user->person->id, $data);

        $user = $this->find($id);

        return $user;
    }
}
