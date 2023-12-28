<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{

        parent::setUp();

        Route::any('route_test', function(){
            return "OK";
        })->middleware(ValidateJsonApiHeaders::class);

    }
    
    /** @test */
    public function header_accept_must_be_in_all_request(): void
    {

        $this->get('route_test')->assertStatus(406);

        $this->get('route_test', [
            'accept' => 'application/json'
        ])->assertSuccessful();

    }

    /** @test */
    public function content_type_must_be_present_in_post_request(): void
    {

        $this->post('route_test', [], [
            'accept' => 'application/json'
        ])->assertStatus(415);

        $this->post('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertSuccessful();

    }

    /** @test */
    public function content_type_must_be_present_in_patch_request(): void
    {

        $this->patch('route_test', [], [
            'accept' => 'application/json'
        ])->assertStatus(415);

        $this->patch('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertSuccessful();

    }

    /** @test */
    public function content_type_must_present_in_all_responses(): void
    {

        $this->get('route_test', [
            'accept' => 'application/json'
        ])->assertHeader('content-type', 'application/json');

        $this->post('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeader('content-type', 'application/json');

        $this->patch('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeader('content-type', 'application/json');

        $this->delete('route_test', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeader('content-type', 'application/json');

    }

    /** @test */
    public function content_type_header_not_must_be_present_in_empty_response(): void
    {

        Route::any('empty_response', function(){
    		return response()->noContent();
    	})->middleware(ValidateJsonApiHeaders::class);

        $this->get('empty_response', [
            'accept' => 'application/json'
        ])->assertHeaderMissing('content-type');

        $this->post('empty_response', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeaderMissing('content-type');

        $this->patch('empty_response', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeaderMissing('content-type');

        $this->delete('empty_response', [], [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ])->assertHeaderMissing('content-type');

    }
}
