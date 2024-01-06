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

    /** @test */
    public function can_include_realted_user_of_all_projects(): void
    {
        
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $projects = Project::factory()->times(2)->create();

        $url = route('api.v1.projects.index', [
            'include' => 'user'
        ]);

        $response = $this->getJson($url, [
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
                ]
            ],
            'included' => [
                [
                    'id' => $projects[0]->user->id,
                    'name' => $projects[0]->user->name,
                    'email' => $projects[0]->user->email,
                    'created_at' => $projects[0]->user->created_at,
                    'updated_at' => $projects[0]->user->updated_at
                ],
                [
                    'id' => $projects[1]->user->id,
                    'name' => $projects[1]->user->name,
                    'email' => $projects[1]->user->email,
                    'created_at' => $projects[1]->user->created_at,
                    'updated_at' => $projects[1]->user->updated_at
                ]
            ]
        ]);

    }

    /** @test */
    public function can_include_related_user_of_an_project(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $url = route('api.v1.projects.show', [
            'project' => $project,
            'include' => 'user'
        ]);

        $this->getJson($url, [
            'authorization' => "Bearer {$token}"
        ])->assertExactJson([
            'data' => [
                'title' => $project->title,
                'description' => $project->description,
                'user_id' => $project->user_id
            ],
            'included' => [
                [
                    'id' => $project->user->id,
                    'name' => $project->user->name,
                    'email' => $project->user->email,
                    'created_at' => $project->user->created_at,
                    'updated_at' => $project->user->updated_at
                ]
            ]
        ]);

    }
    
}
