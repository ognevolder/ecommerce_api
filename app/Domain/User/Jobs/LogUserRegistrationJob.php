<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Models\User;
use App\Infrastructure\Logging\Enums\Action;
use App\Infrastructure\Logging\Enums\Scope;
use App\Infrastructure\Logging\Models\Log;
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
    Log::create([
      'user_id' => $this->user->id,
      'scope' => Scope::AUTHENTICATION,
      'action' => Action::REGISTRATION,
      'info' => "User [{$this->user->name}] registered at {$time}."
    ]);
  }
}