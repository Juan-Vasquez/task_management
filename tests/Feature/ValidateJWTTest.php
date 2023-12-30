<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Http\Middleware\ValidateJsonApiHeaderAuthorization;

class ValidateJWTTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{

        parent::setUp();

        Route::any('route_test', function(){
            return "OK";
        })->middleware(ValidateJsonApiHeaderAuthorization::class);

    }

    /** @test */
    public function header_authentication_must_be_in_get_request(): void
    {

        $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->assertStatus(401);

        $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => ''
        ])->assertStatus(401);

        $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'asdsfdsfdf'
        ])->assertStatus(401);

    }

    /** @test */
    public function header_authentication_must_be_present_in_post_request(): void
    {

        $this->post('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertStatus(401);

        $this->post('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => ''
        ])->assertStatus(401);

        $this->post('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'asdfsfdsd'
        ])->assertStatus(401);

    }

    /** @test */
    public function header_authentication_must_be_present_in_patch_request(): void
    {

        $this->patch('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertStatus(401);

        $this->patch('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => ''
        ])->assertStatus(401);

        $this->patch('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'asdfsdfsdfsdfs'
            ])->assertStatus(401);

    }

    /** @test */
    public function header_authentication_must_be_present_in_delete_request(): void
    {

        $this->delete('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertStatus(401);

        $this->delete('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => ''
        ])->assertStatus(401);

        $this->delete('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'asdfsdfsdfsdfs'
        ])->assertStatus(401);

    }

    /** @test */
    public function jwt_must_be_valid_in_all_request(): void
    {

        $user = User::factory()->create();

        $bearer_token = JWTAuth::fromUser($user);
        
        $response = $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => "Bearer DSDFS$bearer_token"
        ])->dump();
        
        $response->assertStatus(401);

        $response->assertJson(['message' => 'Invalid token']);

        $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => "Bearer $bearer_token"
        ])->assertSuccessful();

    }

    /** @test */
    public function verify_expired_token(): void
    {

        // Revisar bien este test

        $this->expectException(TokenExpiredException::class);

        config(['jwt.ttl' => 0]);

        $user = User::factory()->create();

        $bearer_token = JWTAuth::fromUser($user);

        sleep(1);

        $this->get('route_test', [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => "Bearer {$bearer_token}"
        ])->dump();
        
        $response->assertStatus(401);

        $response->assertJson(['message' => 'Token expired']);

    }
}
