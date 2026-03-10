<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use App\Models\User;

class UserRegistrationAction
{
  public function execute(array $attributes): bool
  {
    $status = User::create($attributes);
    if (! $status) {
      throw new ApiException(message: 'Не вдалося зареєструватися.', status: 422);
    }
    return true;
  }
}