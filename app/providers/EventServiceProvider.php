<?php

namespace App\Providers;

use App\Module\Auth\Events\UserRegistrationEvent;
use App\Module\Auth\Listeners\UserRegistrationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    UserRegistrationEvent::class => [
      UserRegistrationListener::class
    ]
  ];
}