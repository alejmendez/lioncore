<?php

namespace Modules\Core\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Core\Repositories\PersonRepository;

class CachePersonDecorator extends BaseCacheDecorator implements PersonRepository
{
    public function __construct(PersonRepository $Person)
    {
        parent::__construct();
        $this->entityName = 'Person.Persons';
        $this->repository = $Person;
    }

    /**
     * Create or update the Persons
     * @param $Persons
     * @return mixed
     */
    public function createOrUpdate($Persons)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->createOrUpdate($Persons);
    }

    /**
     * Find a Person by its name
     * @param $PersonName
     * @return mixed
     */
    public function findByName($PersonName)
    {
        return $this->remember(function () use ($PersonName) {
            return $this->repository->findByName($PersonName);
        });
    }

    /**
     * Return all modules that have Persons
     * with its Persons
     * @param  array|string $modules
     * @return array
     */
    public function modulePersons($modules)
    {
        return $this->remember(function () use ($modules) {
            return $this->repository->modulePersons($modules);
        });
    }

    /**
     * Return the saved module Persons
     * @param $module
     * @return mixed
     */
    public function savedModulePersons($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->savedModulePersons($module);
        });
    }

    /**
     * Find Persons by module name
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
     * Find the given Person name for the given module
     * @param  string $PersonName
     * @return mixed
     */
    public function get($PersonName)
    {
        return $this->remember(function () use ($PersonName) {
            return $this->repository->get($PersonName);
        });
    }

    /**
     * Return the translatable module Persons
     * @param $module
     * @return array
     */
    public function translatableModulePersons($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->translatableModulePersons($module);
        });
    }

    /**
     * Return the non translatable module Persons
     * @param $module
     * @return array
     */
    public function plainModulePersons($module)
    {
        return $this->remember(function () use ($module) {
            return $this->repository->plainModulePersons($module);
        });
    }
}
