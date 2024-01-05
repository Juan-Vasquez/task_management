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
            'authorization' => "Bearer {$token}"
        ]);

        $response->assertSuccessful();

        $response->assertExactJson([
            'data' => [
                'title' => 'Mi primer Proyecto',
                'description' => 'Esta es mi primera descripcion',
                'user_id' => $user->id
            ]
        ]);
        
    }

    /** @test */
    public function title_of_project_is_required(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $this->postJson(route('api.v1.projects.store'), [
            'description' => 'Esta es mi primera descripcion',
            'user_id' => $user->id
        ], [
            'authorization' => "Bearer {$token}"
        ])->assertJsonValidationErrorFor('title');
        
    }

    /** @test */
    public function description_of_project_is_required(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $this->postJson(route('api.v1.projects.store'), [
            'title' => 'Mi primer proyecto',
            'user_id' => $user->id
        ], [
            'authorization' => "Bearer {$token}"
        ])->assertJsonValidationErrorFor('description');
        
    }

    /** @test */
    public function user_id_of_project_is_required(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $this->postJson(route('api.v1.projects.store'), [
            'title' => 'Mi primer proyecto',
            'description' => 'Esta es mi primera descripcion'
        ], [
            'authorization' => "Bearer {$token}"
        ])->assertJsonValidationErrorFor('user_id');
        
    }

}
