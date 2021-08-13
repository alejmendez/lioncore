<?php
namespace App\Repositories\Cache;

use App\Repositories\Cache\BaseCacheDecorator;
use App\Repositories\NavigationRepository;

class CacheNavigationDecorator extends BaseCacheDecorator implements NavigationRepository
{
    public function __construct(NavigationRepository $navigation)
    {
        parent::__construct();
        $this->entityName = 'Navigation.Navigations';
        $this->repository = $navigation;
    }

    public function getMenu() {
        return $this->remember(function () {
            return $this->repository->getMenu();
        });
    }
}
