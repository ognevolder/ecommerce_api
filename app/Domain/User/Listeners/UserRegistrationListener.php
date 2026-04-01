<?php

namespace App\Domain\User\Listeners;

use App\Domain\User\Events\UserRegistrationEvent;
use App\Domain\User\Jobs\LogUserRegistrationJob;
use App\Domain\User\Jobs\SendWelcomeEmailJob;

class UserRegistrationListener
{
  public function handle(UserRegistrationEvent $event): void
  {
    $user = $event->user;
    // 1. Email
    SendWelcomeEmailJob::dispatch($user)->onQueue('default');

    // 2. Log
    LogUserRegistrationJob::dispatch($user)->onQueue('low');
  }
}