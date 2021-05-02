<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

interface UserRepository extends BaseRepository
{
    /**
     * Find a User by its name
     * @param $userName
     * @return mixed
     */
    public function findByName($userName);

    /**
     * Find a User by its name
     * @param $userName
     * @return mixed
     */
    public function findByEmail($userName);
}
