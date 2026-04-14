<?php

namespace App\Module\Auth\Events;

use App\Module\Auth\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
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