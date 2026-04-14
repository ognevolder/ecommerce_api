<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_registration(): void
  {
    // Define
    $formData = [
      'name' => 'Test User',
      'email' => 'test555@mail.com',
      'password' => '12345678'
    ];
    // Act
    $response = $this->postJson(
      uri: route('auth.registration'),
      data: $formData
      );
    // Assert
    // 1. Status Created(201)?
    $response->assertStatus(201);
    // 2. User created in DB?
    $this->assertDatabaseHas('users', ['email' => $formData['email']]);
  }
}
