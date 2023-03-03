<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\GenerateUserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateInfoTest extends TestCase
{
    use RefreshDatabase,
        GenerateUserToken;
    
    /**
     * A basic feature test example.
     */
    public function test_update_info_successfull(): void
    {
        $user = User::factory()->create();
        // generate token
        $token = $this->generateUserToken($user, []);
        
        $response = $this
            ->withHeaders([
                'Authorization' => "Bearer $token->plainTextToken",
            ])
            ->putJson(route('api.v1.info.update'), [
                'phone' => '+9941112233',
                'email' => 'randomemail@gmail.com',
                'registration_date' => '2022-01-12 12:32',
            ]);

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', __('Successfully updated'))
                    ->has('token')
                    ->etc()
            );
    }
}
