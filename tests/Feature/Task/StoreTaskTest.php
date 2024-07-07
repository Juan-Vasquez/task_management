<?php

namespace Tests\Feature\Task;

use App\Models\Project;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_task(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $project = Project::factory()->create();

        $response = $this->postJson(route('api.v1.tasks.store'), [
            'title' => 'Tarea 1',
            'description' => 'Descripcion tarea 1',
            'due_date' => '2024-02-24',
            'priority' => 'low',
            'completed' => false,
            'project_id' => $project->id
        ], [
            'authorization' => "Bearer {$token}"
        ]);

        $response->assertSuccessful();

        $response->assertExactJson([
            'data' => [
                'title' => 'Tarea 1',
                'description' => 'Descripcion tarea 1',
                'due_date' => '2024-02-24',
                'priority' => 'low',
                'completed' => false,
                'project_id' => $project->id
            ]
        ]);
        
    }
}
