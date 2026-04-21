<?php

namespace App\Module\Product\Exceptions;

use App\Module\Product\Shared\ProductDomainException;

class UnavailableProductException extends ProductDomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Product availability is not sufficent.",
      code: 409
      );
  }
}