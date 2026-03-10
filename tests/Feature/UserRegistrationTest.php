<?php

namespace Tests\Feature;

use App\Models\User;
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
        $response = $this->json('POST', route('auth.registration'), $credentials);
        $registeredUser = User::where('email', $credentials['email'])->first();
        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $credentials['email']]);
        $this->assertAuthenticatedAs($registeredUser);
    }
}
