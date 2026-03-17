<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserValidationAction
{
  public function execute(array $credentials): User
  {
    $user = User::where('email', $credentials['email'])->first();
    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
      throw new ApiException(message: 'Не вдалося верифікувати користувача.', status: 422);
    }
    return $user;
  }
}