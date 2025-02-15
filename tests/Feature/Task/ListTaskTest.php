<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ListTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_task(): void
    {
        
        $user = User::factory()->create();
        
        $token = JWTAuth::fromUser($user);

        $task = Task::factory()->create();

        $response = $this->getJson(route('api.v1.tasks.show', $task), [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertExactJson([
            'data' => [
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $task->due_date,
                'priority' => $task->priority,
                'completed' => $task->completed,
                'project_id' => $task->project_id
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_tasks(): void
    {
        $tasks = Task::factory()->times(3)->create();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->getJson(route('api.v1.tasks.index'), [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertExactJson([
            'data' => [
                [
                    'title' => $tasks[0]->title,
                    'description' => $tasks[0]->description,
                    'due_date' => $tasks[0]->due_date,
                    'priority' => $tasks[0]->priority,
                    'completed' => $tasks[0]->completed,
                    'project_id' => $tasks[0]->project_id
                ],
                [
                    'title' => $tasks[1]->title,
                    'description' => $tasks[1]->description,
                    'due_date' => $tasks[1]->due_date,
                    'priority' => $tasks[1]->priority,
                    'completed' => $tasks[1]->completed,
                    'project_id' => $tasks[1]->project_id
                ],
                [
                    'title' => $tasks[2]->title,
                    'description' => $tasks[2]->description,
                    'due_date' => $tasks[2]->due_date,
                    'priority' => $tasks[2]->priority,
                    'completed' => $tasks[2]->completed,
                    'project_id' => $tasks[2]->project_id
                ]
            ]
        ]);

    }
}
