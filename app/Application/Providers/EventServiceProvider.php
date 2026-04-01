<?php

namespace App\Application\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\User\Events\UserRegistrationEvent;
use App\Domain\User\Listeners\UserRegistrationListener;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    UserRegistrationEvent::class => [
        UserRegistrationListener::class,
    ],
  ];
}