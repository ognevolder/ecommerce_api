<?php

namespace App\Domain\User\Services;

use App\Domain\User\DTO\UserLoginDTO;
use App\Domain\User\DTO\UserRegistrationDTO;
use App\Domain\User\Events\UserLoginEvent;
use App\Domain\User\Events\UserLogoutEvent;
use App\Domain\User\Events\UserRegistrationEvent;
use App\Domain\User\Exceptions\InvalidCredentialsException;
use App\Domain\User\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 *  --- User Registration/Authentication Service.
 * 1. State machine: bool|DomainException.
 * 2. Action: User|DomainException.
 * 3. Event: Event.
 * 4. Return: ProductResource.
 */
class AuthService
{
  /**
   * User registration.
   *
   * @param UserRegistrationDTO $dto
   * @return User
   */
  public function register(UserRegistrationDTO $dto): User
  {
    // --- Action.
    $user = User::create([
      'name' => $dto->name,
      'email' => $dto->email,
      'password' => $dto->password
    ])->fresh();
    // --- Event.
    event(new UserRegistrationEvent($user));
    // --- Return.
    return $user;
  }

  /**
   * User authentication.
   *
   * @param UserLoginDTO $dto
   * @return array
   */
  public function login(UserLoginDTO $dto): array
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
    $role = $user->role;
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

  /**
   * User logout on current source.
   *
   * @param $user
   * @return void
   */
  public function logout($user): void
  {
    // --- Action.
    $user->currentAccessToken()->delete();

    // --- Event.
    event(new UserLogoutEvent($user));
  }

  /**
   * Terminate access on all sources.
   *
   * @param $user
   * @return void
   */
  public function terminate($user): void
  {
    // --- Action.
    $user->tokens()->delete();

    // --- Event.
    event(new UserLogoutEvent($user));
  }
}