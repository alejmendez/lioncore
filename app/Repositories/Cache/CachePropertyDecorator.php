<?php
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\PropertyRepository;

class CachePropertyDecorator extends BaseCacheDecorator implements PropertyRepository
{
    public function __construct(PropertyRepository $property)
    {
        parent::__construct();
        $this->entityName = 'Property.Properties';
        $this->repository = $property;
    }
}
