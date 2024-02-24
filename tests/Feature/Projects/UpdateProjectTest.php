<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_a_project(): void
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $user = User::find($project->user_id);

        $token = JWTAuth::fromUser($user);

        $response = $this->patchJson(route('api.v1.projects.update', $project), [
            'title' => 'Actualizando Proyecto',
            'description' => 'Texto actualizado',
            'user_id' => $user->id
        ],[
            'authorization' => "Bearer {$token}"
        ]);

        $response->assertOk();
    }

    /** @test */
    public function project_title_to_update_is_required(): void
    {
        $project = Project::factory()->create();

        $user = User::find($project->user_id);

        $token = JWTAuth::fromUser($user);

        $this->patchJson(route('api.v1.projects.update', $project), [
            'description' => 'Esta es mi primera descripcion',
            'user_id' => $user->id
        ], [
            'authorization' => "Bearer {$token}"
        ])->assertJsonValidationErrorFor('title');
        
    }

    /** @test */
    public function project_description_to_update_is_required(): void
    {
        $project = Project::factory()->create();

        $user = User::find($project->user_id);

        $token = JWTAuth::fromUser($user);

        $this->patchJson(route('api.v1.projects.update', $project), [
            'title' => 'Actualizando Titulo',
            'user_id' => $user->id
        ], [
            'authorization' => "Bearer {$token}"
        ])->assertJsonValidationErrorFor('description');
        
    }

    /** @test */
    public function project_user_id_to_update_is_required(): void
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
