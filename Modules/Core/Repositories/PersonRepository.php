<?php

namespace Modules\Core\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PersonRepository extends BaseRepository
{
    /**
     * Find a Person by its name
     * @param $personName
     * @return mixed
     */
    public function findByName($personName);

    /**
     * Find a Person by its name
     * @param $personName
     * @return mixed
     */
    public function findByEmail($personName);
}
