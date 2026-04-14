<?php

namespace App\Module\Auth\Shared;

use App\Module\Auth\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuthenticationEvent
{
  use Dispatchable, SerializesModels;

  public $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }
}