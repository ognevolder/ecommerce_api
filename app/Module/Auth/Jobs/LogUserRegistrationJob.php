<?php

namespace App\Module\Auth\Jobs;

use App\Module\Auth\Models\User;
use App\Module\Logging\Enums\Action;
use App\Module\Logging\Enums\Scope;
use App\Module\Logging\Models\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogUserRegistrationJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function __construct(
    protected User $user
  ) {}

  public function handle(): void
  {
    $time = now()->toDateTimeString();
    $name = $this->user->name;
    $user = $this->user->role->label();
    Log::create([
      'user_id' => $this->user->id,
      'scope' => Scope::Auth,
      'action' => Action::Registration,
      'info' => "{$user} [{$name}] registered at {$time}."
    ]);
  }
}