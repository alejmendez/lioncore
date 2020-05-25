<?php

namespace Modules\Auth\Tests\Feature;

use Log;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Tests\BaseAuthTest as TestCase;

use Modules\User\Models\User;

class AuthenticationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = $this->userRepository->findByEmail('test2@gmail.cl');
        if ($user) {
            $user->forceDelete();
        }

        $user = $this->userRepository->findByEmail('test@gmail.cl');
        if ($user) {
            $user->forceDelete();
        }

        $user = $this->userRepository->create([
            'email' => 'test@gmail.cl',
            'password' => '12345678',
        ]);

        $user->save();
    }

    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/v1/auth/register', [
            'name'     => 'test2',
            'email'    => 'test2@gmail.cl',
            'password' => '12345678',
        ]);

        // $response->dumpHeaders();
        // $response->dump();

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'token',
                'token_type',
                'expires_in'
            ]);
    }

    /** @test */
    public function will_not_register_an_existing_user()
    {
        $response = $this->post('api/v1/auth/register', [
            'name'     => Str::random(20),
            'email'    => 'test@gmail.cl',
            'password' => '12345678',
        ]);

        // $response->dumpHeaders();
        // $response->dump();

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error'
            ]);
    }

    /** @test */
    public function it_will_log_a_user_in()
    {
        $response = $this->post('api/v1/auth/login', [
            'email'    => 'test@gmail.cl',
            'password' => '12345678'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'token_type',
                'expires_in'
            ]);
    }

    /** @test */
    public function it_will_not_log_an_invalid_user_in()
    {
        $response = $this->post('api/v1/auth/login', [
            'email'    => 'test@gmail.cl',
            'password' => 'notlegitpassword'
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error',
            ]);
    }
}
