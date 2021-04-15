<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use WithFaker, CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $userAdmin = User::whereEmail('admin@test.cl')->first();
        $this->actingAs($userAdmin);
    }


    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string|null                                $driver
     * @return $this
     */
    public function actingAs($user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withToken($token);
        parent::actingAs($user);

        return $this;
    }
}
