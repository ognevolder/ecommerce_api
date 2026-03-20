<?php

namespace Tests\Feature;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * User registration
     */
    public function test_user_registration(): void
    {
        $credentials = User::factory()->make()->getAttributes();
        $credentials['password'] = '12345678';
        // Act
        $response = $this->postJson(route('auth.registration'), $credentials);
        // Assert
        // 1. Status Created(201)?
        $response->assertStatus(201);
        // 2. User created in DB?
        $this->assertDatabaseHas('users', ['email' => $credentials['email']]);
        // 3. User recieved access API-token?
        $response->assertJsonStructure(['data' => ['name', 'email', 'role', 'token']]);
        // 4. API-token is valid?
            // Define
            $token = $response->json('data.token');
            // Act
            $authResponse = $this->withToken($token)->getJson(route('user.orders'));
            // Assert
            $authResponse->assertStatus(200);
    }
}
