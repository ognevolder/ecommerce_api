<?php

namespace App\Module\Auth\Services;

use App\Module\Auth\Events\UserLogoutEvent;

class LogoutService
{
  public function __invoke($user): void
  {
    // --- Action.
    $user->currentAccessToken()->delete();

    // --- Event.
    event(new UserLogoutEvent($user));
  }
}