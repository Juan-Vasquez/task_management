<?php

namespace Tests\Feature\Register;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_user(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.register'), [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
        ]);

        $this->assertTrue(JWTAuth::setToken($response->json('access_token'))->check());
    }

    /** @test */
    public function name_is_required(): void
    {

        $this->postJson(route('api.v1.register'), [
            //'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function email_is_required(): void
    {

        $this->postJson(route('api.v1.register'), [
            'name' => 'Juan Vasquez',
            // 'email' => 'avasquez@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function password_is_required(): void
    {

        $this->postJson(route('api.v1.register'), [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
            // 'password' => 'password',
            'password_confirmation' => 'password'
        ])->assertJsonValidationErrorFor('password');
    }

    /** @test */
    public function password_must_be_confirmed(): void
    {

        $this->postJson(route('api.v1.register'), [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
            'password' => 'password',
            'password_confirmation' => 'not-confirmed'
        ])->assertJsonValidationErrors('password');
    }

}
