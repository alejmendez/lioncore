<?php

namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\UserRepository;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'User.Users';
        $this->repository = $user;
    }

    /**
     * Find a User by its name
     * @param $userName
     * @return mixed
     */
    public function findByName($userName)
    {
        return $this->remember(function () use ($userName) {
            return $this->repository->findByName($userName);
        });
    }
}
