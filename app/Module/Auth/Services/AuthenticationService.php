<?php

namespace App\Module\Auth\Services;

use App\Module\Auth\DTOs\UserLoginDTO;
use App\Module\Auth\Events\UserLoginEvent;
use App\Module\Auth\Exceptions\InvalidCredentialsException;
use App\Module\Auth\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
  /**
   * User authentication.
   *
   * @param UserLoginDTO $dto
   * @return array
   */
  public function __invoke(UserLoginDTO $dto): array
  {
    $credentials = [
      'email' => $dto->email,
      'password' => $dto->password
      ];
    // --- Action.
    // Fetch user: User
    $user = User::where('email', $credentials['email'])->first();
    // Authentication attempt: bool|InvalidCredentials Domain Exception
    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
      throw new InvalidCredentialsException();
    }
    // Create token: string
    $user->tokens()->delete();
    $role = $user->role->value;
    $timestamp = Carbon::now()->addMinutes(180);
    $token = $user->createToken('auth_token', [$role], $timestamp)->plainTextToken;

    // --- Event.
    event(new UserLoginEvent($user));

    // --- Return.
    return [
      'user' => $user->fresh(),
      'token' => $token
    ];
  }
}