<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SignupTest extends TestCase
{
    use RefreshDatabase;   
    
    /**
     * A basic feature test example.
     * @group signup
     */
    public function test_signup(): void
    {
        $response = $this->postJson("api/v1/signup", [
            "username" => "johndoe",
            "phone" => "+994703503738",
            "email" => "johndoe@gmail.com",
            "password" => "password",
            "password_confirmation" => "password",
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('success', true)
                    ->has('message')
                    ->has('token')
                    ->has('user')
                    ->where('user.username', 'johndoe')
                    ->where("user.phone", "+994703503738")
                    ->where("user.email", "johndoe@gmail.com")
        );
    }
}
