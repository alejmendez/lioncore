<?php

namespace App\Tests;

use Tests\TestCase;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;

abstract class BaseWorkshopTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
