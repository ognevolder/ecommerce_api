<?php

namespace App\Module\Auth\Jobs;

use App\Module\Auth\Shared\AuthenticationJob;
use App\Module\Logging\Enums\Action;
use App\Module\Logging\Enums\Scope;
use App\Module\Logging\Models\Log;

class LogUserLogoutJob extends AuthenticationJob
{
  public function handle(): void
  {
    $time = now()->toDateTimeString();
    $name = $this->user->name;
    $user = $this->user->role->label();
    Log::create([
      'user_id' => $this->user->id,
      'scope' => Scope::Auth,
      'action' => Action::Login,
      'info' => "{$user} [{$name}] logged out at {$time}."
    ]);
  }
}