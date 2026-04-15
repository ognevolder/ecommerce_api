<?php

namespace App\Module\Product\Exceptions;

class TransitionDeniedException extends \DomainException
{
  public function __construct(string $message)
  {
    return parent::__construct(
      message: $message,
      code: 401
      );
  }
}