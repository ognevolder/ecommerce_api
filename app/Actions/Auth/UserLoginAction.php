<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Auth;

class UserLoginAction
{
  public function execute(array $credentials): bool
  {
    if (! Auth::attempt($credentials)) {
      throw new ApiException('Не вдалося авторизуватися.', 401);
    }
    return true;
  }
}