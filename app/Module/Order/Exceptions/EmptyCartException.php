<?php

namespace App\Module\Order\Exceptions;

class EmptyCartException extends \DomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Your cart is empty.",
      code: 401
      );
  }
}