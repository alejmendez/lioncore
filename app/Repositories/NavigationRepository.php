<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

interface NavigationRepository extends BaseRepository
{
    public function getMenu();
}
