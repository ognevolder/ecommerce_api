<?php

namespace App\Domain\User\Shared;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AuthenticationEvent
{
  use Dispatchable, SerializesModels;

  public $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }
}