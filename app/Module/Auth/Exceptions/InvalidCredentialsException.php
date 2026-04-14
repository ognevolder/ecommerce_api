<?php

namespace App\Module\Auth\Exceptions;

class InvalidCredentialsException extends \DomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Invalid credentials. Please try again.",
      code: 401
      );
  }
}