<?php

namespace App\Module\Auth\Listeners;

use App\Module\Auth\Events\UserLogoutEvent;
use App\Module\Auth\Jobs\LogUserLogoutJob;

class UserLogoutListener
{
  public function handle(UserLogoutEvent $event): void
  {
    LogUserLogoutJob::dispatch($event->user)->onQueue('low');
  }
}