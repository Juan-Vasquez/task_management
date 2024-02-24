<?php

namespace Tests\Feature\Projects;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_a_project(): void
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $user = User::find($project->user_id);

        $token = JWTAuth::fromUser($user);

        $this->deleteJson(route('api.v1.projects.destroy', $project), [], [
            'authorization' => "Bearer $token"
        ])->assertNoContent();

        
    }
}
