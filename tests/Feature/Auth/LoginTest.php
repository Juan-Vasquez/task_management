<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_login_a_user(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->postJson(route('api.v1.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();

        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);

        $this->assertTrue(JWTAuth::setToken($response->json('access_token'))->check());
    }

    /** @test */
    public function for_login_email_is_required(): void
    {
        $this->postJson(route('api.v1.login'), [
            //'email' => 'avasquez@test.com',
            'password' => 'password',
        ])->assertJsonValidationErrorFor('email');
    }

    /** @test */
    public function for_login_password_is_required(): void
    {
        $this->postJson(route('api.v1.login'), [
            'email' => 'avasquez@test.com',
            // 'password' => 'password',
        ])->assertJsonValidationErrorFor('password');
    }
}
