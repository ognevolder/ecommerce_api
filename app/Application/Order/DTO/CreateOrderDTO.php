<?php

namespace App\Application\Order\DTO;

class CreateOrderDTO
{
  public function __construct(
    public readonly int $customerId,
    public readonly array $items
  ) {}
}