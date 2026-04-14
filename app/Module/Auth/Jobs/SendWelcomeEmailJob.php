<?php

namespace App\Module\Auth\Jobs;

use App\Module\Auth\Mail\WelcomeMail;
use App\Module\Auth\Shared\AuthenticationJob;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob extends AuthenticationJob
{
  public function handle(): void
  {
    Mail::to($this->user->email)->send(new WelcomeMail($this->user));
  }
}