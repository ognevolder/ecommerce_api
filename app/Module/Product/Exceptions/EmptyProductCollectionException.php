<?php

namespace App\Module\Product\Exceptions;

class EmptyProductCollectionException extends \DomainException
{
  public function __construct()
  {
    return parent::__construct(
      message: "Product list is not found.",
      code: 404
      );
  }
}