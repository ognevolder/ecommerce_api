<?php

namespace App\Domain\User\Listeners;

use App\Domain\User\Events\UserLogoutEvent;
use App\Domain\User\Jobs\LogUserLogoutJob;

class UserLogoutListener
{
  public function handle(UserLogoutEvent $event): void
  {
    $user = $event->user;

    // --- Log.
    LogUserLogoutJob::dispatch($user)->onQueue('low');
  }
}