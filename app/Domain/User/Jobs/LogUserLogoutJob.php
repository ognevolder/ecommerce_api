<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Shared\QueueJob;
use App\Infrastructure\Logging\Enums\Action;
use App\Infrastructure\Logging\Enums\Scope;
use App\Infrastructure\Logging\Models\Log;

class LogUserLogoutJob extends QueueJob
{
  public function handle(): void
  {
    $time = now()->toDateTimeString();
    $name = $this->user->name;
    $user = $this->user->role->value;
    Log::create([
      'user_id' => $this->user->id,
      'scope' => Scope::AUTHENTICATION,
      'action' => Action::LOGOUT,
      'info' => "{$user} [{$name}] logged out at {$time}."
    ]);
  }
}