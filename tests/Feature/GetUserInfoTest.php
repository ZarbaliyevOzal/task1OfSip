<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\GenerateUserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetUserInfoTest extends TestCase
{
    use RefreshDatabase, GenerateUserToken;

    /**
     * A basic feature test example.
     */
    public function test_get_user_info(): void
    {
        $user = User::factory()->create();
        // generate user token
        $token = $this->generateUserToken($user, []);
        
        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer $token->plainTextToken",
            ])
            ->getJson(route('api.v1.info'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('user.username', $user->username)
                    ->where("user.phone", $user->phone)
                    ->where("user.email", $user->email)
                    ->etc()
            );
    }
}
