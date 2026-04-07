<?php

namespace App\Domain\Order\Exceptions;

class OrderNotFoundException extends OrderException
{
  public function __construct(int $id)
  {
    parent::__construct(
      message: "Order with id ({$id}) not found.",
      code: 404
    );
  }
}