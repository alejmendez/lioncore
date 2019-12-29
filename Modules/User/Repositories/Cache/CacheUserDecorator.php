<?php

namespace Modules\User\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\User\Repositories\UserRepository;

class CacheUserDecorator extends BaseCacheDecorator implements UserRepository
{
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->entityName = 'User.Users';
        $this->repository = $user;
    }

    /**
     * Create or update the Users
     * @param $users
     * @return mixed
     */
    public function createOrUpdate($users)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->createOrUpdate($users);
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

    /**
     * Return all modules that have Users
     * with its Users
     * @param  array|string $modules
     * @return array
     */
    public function moduleUsers($modules)
    {
        return $this->remember(function () use ($modules) {
            return $this->repository->moduleUsers($modules);
        });
    }

    /**
     * Return the saved module Users
     * @param $module
     * @return mixed
     */
    public function savedModuleUsers($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->savedModuleUsers($module);
        });
    }

    /**
     * Find Users by module name
     * @param  string $module
     * @return mixed
     */
    public function findByModule($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->findByModule($module);
        });
    }

    /**
     * Find the given User name for the given module
     * @param  string $userName
     * @return mixed
     */
    public function get($userName)
    {
        return $this->remember(function () use ($userName) {
            return $this->repository->get($userName);
        });
    }

    /**
     * Return the translatable module Users
     * @param $module
     * @return array
     */
    public function translatableModuleUsers($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->translatableModuleUsers($module);
        });
    }

    /**
     * Return the non translatable module Users
     * @param $module
     * @return array
     */
    public function plainModuleUsers($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->plainModuleUsers($module);
        });
    }
}
