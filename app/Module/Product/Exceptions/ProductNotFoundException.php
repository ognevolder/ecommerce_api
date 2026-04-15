<?php

namespace App\Module\Product\Exceptions;

class ProductNotFoundException extends \DomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Product with selected ID is not found.",
      code: 404
      );
  }
}