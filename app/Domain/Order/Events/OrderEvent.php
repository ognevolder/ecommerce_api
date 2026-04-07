<?php

namespace App\Domain\Order\Events;

use App\Domain\Order\ValueObjects\Money;

abstract class OrderEvent
{
  public function __construct(
    public readonly int $orderId,
    public readonly int $customerId,
    public readonly Money $total,
    public readonly array $orderItems
  ) {}
}