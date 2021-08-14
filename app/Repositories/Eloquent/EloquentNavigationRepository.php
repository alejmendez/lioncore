<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\NavigationRepository;

class EloquentNavigationRepository extends EloquentBaseRepository implements NavigationRepository
{
    public function getMenu() {
        return $this->getModel()->orderBy('order', 'ASC')->get();
    }
}
