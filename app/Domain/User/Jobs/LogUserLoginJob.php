<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Shared\QueueJob;
use App\Infrastructure\Logging\Enums\Action;
use App\Infrastructure\Logging\Enums\Scope;
use App\Infrastructure\Logging\Models\Log;

class LogUserLoginJob extends QueueJob
{
  public function handle(): void
  {
    $time = now()->toDateTimeString();
    $name = $this->user->name;
    $user = $this->user->role->value;
    Log::create([
      'user_id' => $this->user->id,
      'scope' => Scope::AUTHENTICATION,
      'action' => Action::LOGIN,
      'info' => "{$user} [{$name}] logged in at {$time}."
    ]);
  }
}