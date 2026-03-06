<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;

class TokenCreationAction
{
  public function execute(User $user): string
  {
    // Delete old tokens
    $user->tokens()->delete();
    // Variables
    $role = $user->role;
    $timestamp = Carbon::now()->addMinutes(180);
    // Create token
    return $user->createToken('auth_token', [$role], $timestamp)->plainTextToken;
  }
}