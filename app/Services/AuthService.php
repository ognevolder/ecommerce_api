<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthService
{
  /**
   * Create User
   *
   * @param array $attributes
   * @return User
   */
  public function register(array $attributes): User
  {
    return User::create($attributes);
  }

  public function login(array $credentials, User $user): User
  {
    $status = Auth::attempt($credentials);
    if (! $status) {
      throw new ApiException('Не вдалося авторизуватися.', 401);
    }
    $role = $user->role;
    $user->tokens()->delete();
    $token = $user->createToken('auth_token', [$role], Carbon::now()->addMinutes(180))->plainTextToken;
    // return DTO
  }


}