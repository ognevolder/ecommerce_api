<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login(): void
    {
        // Define
        $user = User::factory()->create();
        $credentials = $user->getAttributes();
        $credentials['password'] = '12345678';
        // Act
        $response = $this->postJson(route('auth.login'), $credentials);
        // Assert
            // 1. Status 200.
            $response->assertStatus(200);
            // 2. JSON structure.
            $response->assertJsonStructure(['data' => ['name', 'email', 'role', 'token']]);
            // 3. API-token is valid?
                // Define
                $token = $response->json('data.token');
                // Act
                $authResponse = $this->withToken($token)->getJson(route('user.orders'));
                // Assert
                $authResponse->assertStatus(200);
    }
}
