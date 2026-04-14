<?php

namespace App\Module\Auth\Listeners;

use App\Module\Auth\Events\UserLoginEvent;
use App\Module\Auth\Jobs\LogUserLoginJob;

class UserLoginListener
{
  public function handle(UserLoginEvent $event): void
  {
    LogUserLoginJob::dispatch($event->user)->onQueue('low');
  }
}