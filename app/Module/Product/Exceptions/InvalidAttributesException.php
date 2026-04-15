<?php

namespace App\Module\Product\Exceptions;


class InvalidAttributesException extends \DomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Invalid attributes for Product. Please, enter data carefully.",
      code: 422
      );
  }
}