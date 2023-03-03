<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SigninTest extends TestCase
{
    /**
     * A basic feature test example.
     * 
     * @group apiv1Login
     */
    public function test_successfull_signin(): void
    {
        $user = User::factory()->create();
        
        $response = $this->postJson(route('api.v1.signin'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('message', __('Successfully logged in'))
                    ->has('token')
                    ->where('user.username', $user->username)
                    ->where("user.phone", $user->phone)
                    ->where("user.email", $user->email)
            );
    }
}
