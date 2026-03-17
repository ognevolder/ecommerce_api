<?php

namespace App\Domain\Product\Exceptions;

use DomainException;

class NotPublishableException extends DomainException
{
  protected $message = "Product is already published.";
}