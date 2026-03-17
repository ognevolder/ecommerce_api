<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use App\Models\User;

class UserRegistrationAction
{
  public function execute(array $attributes): User
  {
    $user = User::create($attributes);
    if (! $user) {
      throw new ApiException(message: 'Не вдалося зареєструватися.', status: 422);
    }
    return $user;
  }
}