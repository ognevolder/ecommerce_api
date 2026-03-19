<?php

namespace App\Domain\Shared\Exception;

use Exception;

abstract class DomainException extends Exception
{
  protected string $message;
  protected int $status;

  public function __construct(string $message, int $status)
  {
    return parent::__construct();
  }
}