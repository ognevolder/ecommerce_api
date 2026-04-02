<?php

namespace App\Domain\User\Jobs;

use App\Domain\User\Mail\WelcomeMail;
use App\Domain\User\Shared\QueueJob;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob extends QueueJob
{
  public function handle(): void
  {
    Mail::to($this->user->email)->send(new WelcomeMail($this->user));
  }
}