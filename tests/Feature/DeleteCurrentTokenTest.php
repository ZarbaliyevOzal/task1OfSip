<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\GenerateUserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteCurrentTokenTest extends TestCase
{
    use RefreshDatabase,
        GenerateUserToken;
    
    /**
     * A basic feature test example.
     */
    public function test_delete_current_token(): void
    {
        $user = User::factory()->create();
        // generate token
        $token = $this->generateUserToken($user, []);
        
        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer $token->plainTextToken",
            ])
            ->deleteJson(route('api.v1.token'), []);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', __('Token was successfully deleted'))
                    ->has('token')
                    ->etc()
            );
    }
}
