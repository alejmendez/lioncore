<?php
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\PersonRepository;

class CachePersonDecorator extends BaseCacheDecorator implements PersonRepository
{
    public function __construct(PersonRepository $person)
    {
        parent::__construct();
        $this->entityName = 'Person.People';
        $this->repository = $person;
    }
}
