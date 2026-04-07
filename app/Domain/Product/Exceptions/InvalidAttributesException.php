<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Product\Shared\ProductDomainException;

class InvalidAttributesException extends ProductDomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Invalid attributes for Product. Please, enter carefully.",
      code: 422
      );
  }
}