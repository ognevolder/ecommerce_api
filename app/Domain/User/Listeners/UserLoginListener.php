<?php

namespace App\Domain\User\Listeners;

use App\Domain\User\Events\UserLoginEvent;
use App\Domain\User\Jobs\LogUserLoginJob;

class UserLoginListener
{
  public function handle(UserLoginEvent $event): void
  {
    $user = $event->user;

    // --- Log.
    LogUserLoginJob::dispatch($user)->onQueue('low');
  }
}