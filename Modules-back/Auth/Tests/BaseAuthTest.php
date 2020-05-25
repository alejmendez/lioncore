<?php

namespace Modules\Auth\Tests;

use Tests\TestCase;
use Modules\Core\Repositories\PersonRepository;
use Modules\User\Repositories\UserRepository;

abstract class BaseAuthTest extends TestCase
{
    protected $userRepository;
    protected $personRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = app(UserRepository::class);
        $this->personRepository = app(PersonRepository::class);
    }
}
