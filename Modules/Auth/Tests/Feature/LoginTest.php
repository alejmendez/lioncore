<?php

namespace Modules\Auth\Tests\Feature;

use Log;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Modules\User\Models\User;

class AuthenticationTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        User::whereEmail('test2@netred.cl')->delete();

        $user = User::firstOrNew([
            'email' => 'test@netred.cl',
        ]);

        $user->fill([
            'name'     => 'test',
            'password' => '12345678',
        ]);

        $user->save();
    }

    /** @test */
    public function it_will_register_a_user()
    {
        $response = $this->post('api/v1/auth/register', [
            'name'     => 'test2',
            'email'    => 'test2@netred.cl',
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
            'email'    => 'test@netred.cl',
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
            'email'    => 'test@netred.cl',
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
            'email'    => 'test@netred.cl',
            'password' => 'notlegitpassword'
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error',
            ]);
    }
}
