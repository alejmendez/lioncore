<?php

namespace Modules\Workshop\Tests;

use Tests\TestCase;
use Modules\Core\Repositories\PersonRepository;
use Modules\User\Repositories\UserRepository;

abstract class BaseWorkshopTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }
}
