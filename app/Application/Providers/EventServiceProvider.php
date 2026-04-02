<?php

namespace App\Application\Providers;

use App\Domain\User\Events\UserLoginEvent;
use App\Domain\User\Events\UserLogoutEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\User\Events\UserRegistrationEvent;
use App\Domain\User\Listeners\UserLoginListener;
use App\Domain\User\Listeners\UserLogoutListener;
use App\Domain\User\Listeners\UserRegistrationListener;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    UserRegistrationEvent::class => [UserRegistrationListener::class],
    UserLoginEvent::class => [UserLoginListener::class],
    UserLogoutEvent::class => [UserLogoutListener::class]
  ];
}