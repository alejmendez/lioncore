<?php

namespace Modules\User\Repositories;

use Modules\Core\Repositories\BaseRepository;

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
