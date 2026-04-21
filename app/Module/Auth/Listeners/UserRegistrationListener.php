<?php

namespace App\Module\Auth\Listeners;

use App\Module\Auth\Events\UserRegistrationEvent;
use App\Module\Auth\Jobs\LogUserRegistrationJob;
use App\Module\Auth\Jobs\SendWelcomeEmailJob;
use App\Module\Cart\Jobs\CreateCustomerCartJob;

class UserRegistrationListener
{
  public function handle(UserRegistrationEvent $event): void
  {
    $user = $event->user;
    // 1. Email
    SendWelcomeEmailJob::dispatch($user)->onQueue('default');

    // 3. Log
    LogUserRegistrationJob::dispatch($user)->onQueue('low');
  }
}