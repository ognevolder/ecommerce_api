<?php

namespace App\Domain\User\Exceptions;

use App\Domain\User\Shared\UserDomainException;

class InvalidCredentialsException extends UserDomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Invalid credentials. Please try again.",
      code: 401
      );
  }
}