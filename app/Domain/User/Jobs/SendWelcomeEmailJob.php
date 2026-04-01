<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Mail\WelcomeMail;
use App\Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public int $tries = 3;
  public array $backoff = [10, 30, 60];

  public function __construct(
    protected User $user
  ) {}

  public function handle(): void
  {
    Mail::to($this->user->email)->send(new WelcomeMail($this->user));
  }
}