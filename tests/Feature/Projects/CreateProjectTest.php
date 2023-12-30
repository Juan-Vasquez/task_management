<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_create_projects(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->postJson(route('api.v1.projects.store'), [
            'title' => 'Mi primer Proyecto',
            'description' => 'Esta es mi primera descripcion',
            'user_id' => $user->id
        ], [
            'authorization' => $token
        ]);

        $response->assertSuccessful();
        
    }
}
