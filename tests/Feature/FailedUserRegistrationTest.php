<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FailedUserRegistrationTest extends TestCase
{
  use RefreshDatabase;
  public function test_failed_user_registration()
  {
    // Define
    $existingUser = User::factory()->create();
    $credentials = $existingUser->getAttributes();
    $credentials['password'] = '12345678';
    // Act
    $response = $this->postJson(route('auth.registration'), $credentials);
    // Assert
      // 1. Status 422 with errors.
      $response->assertStatus(422)->assertJsonValidationErrors(['email']);
      // 2. DB check.
      $this->assertDatabaseCount('users', 1);
  }
}
