<?php

namespace Tests\Feature;

use App\Module\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_login(): void
  {
    // Define
    $formData = [
      'name' => 'Test User',
      'email' => 'test555@mail.com',
      'password' => '12345678'
    ];
    $user = User::factory()->create($formData);

    // Act
    $response = $this->postJson(route('auth.login'), $formData);
    // Assert
      // 1. Status 200.
      $response->assertStatus(200);
      // 2. JSON structure.
      $response->assertJsonStructure([
        'data' => [
          'user' => ['id', 'name', 'email', 'role'],
          'token'
        ]
      ]);
      // 3. API-token is valid?
        // Define
        $token = $response->json('data.token');
        // Act
        $authResponse = $this->withToken($token)->getJson(route('profile'));
        // Assert
        $authResponse->assertStatus(200);
  }
}

