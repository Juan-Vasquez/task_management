<?php

namespace Tests\Feature\Register;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_user(): void
    {
        $this->withoutExceptionHandling();

        $this->postJson(route('api.v1.register'), [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Vasquez',
            'email' => 'avasquez@test.com',
        ]);
    }
}
