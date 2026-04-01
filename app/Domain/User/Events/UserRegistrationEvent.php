<?php

namespace App\Domain\User\Events;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationEvent
{
  use Dispatchable, SerializesModels;

  public $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }
}