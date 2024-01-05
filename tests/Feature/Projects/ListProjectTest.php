<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_all_projects(): void
    {
        
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $projects = Project::factory()->times(3)->create(['user_id' => $user->id]);

        $response = $this->getJson(route('api.v1.projects.index'), [
            'authorization' => "Bearer {$token}"
        ]);

        $response->assertExactJson([
            'data' => [
                [
                    'title' => $projects[0]->title,
                    'description' => $projects[0]->description,
                    'user_id' => $projects[0]->user_id
                ],
                [
                    'title' => $projects[1]->title,
                    'description' => $projects[1]->description,
                    'user_id' => $projects[1]->user_id
                ],
                [
                    'title' => $projects[2]->title,
                    'description' => $projects[2]->description,
                    'user_id' => $projects[2]->user_id
                ]
            ]
        ]);

    }

    /** @test */
    public function can_fetch_single_a_project(): void
    {
        
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson(route('api.v1.projects.show', $project), [
            'authorization' => "Bearer {$token}"
        ]);

        $response->assertExactJson([
            'data' => [
                'title' => $project->title,
                'description' => $project->description,
                'user_id' => $project->user_id
            ]
        ]);

    }
}
