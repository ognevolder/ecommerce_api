<?php

namespace App\Services;

use App\Actions\Auth\TokenCreationAction;
use App\Actions\Auth\UserValidationAction;
use App\Actions\Auth\UserRegistrationAction;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
  public function __construct(
    private UserValidationAction $validation,
    private TokenCreationAction $token,
    private UserRegistrationAction $registration
  ) {}

  /**
   * Create User
   *
   * @param array $attributes
   * @return User
   */
  public function register(array $attributes)
  {
    // Create User
    $this->registration->execute($attributes);
    // Validate User
    $user = $this->validation->execute($attributes);
    // Create access API-token
    $token = $this->token->execute($user);
    // Return
    return [
      'user' => $user,
      'token' => $token
    ];
  }

  /**
   * Login user
   *
   * @param array $credentials
   * @param User $user
   * @return User
   */
  public function login(array $credentials, User $user)
  {
    //
  }
}