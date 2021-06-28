<?php
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\RoleRepository;

class CacheRoleDecorator extends BaseCacheDecorator implements RoleRepository
{
    public function __construct(RoleRepository $role)
    {
        parent::__construct();
        $this->entityName = 'Role.Roles';
        $this->repository = $role;
    }
}
