<?php

namespace App\Domain\Order\Entities;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\ValueObjects\Money;
use DateTimeImmutable;

class Order
{
  public function __construct(
    private int $id,
    private int $customerId,
    private OrderStatus $status,
    private Money $total,
    private DateTimeImmutable $expiresAt
  ) {}

  public function id(): int
  {
    return $this->id;
  }

  public function customerId(): int
  {
    return $this->customerId;
  }

  public function status(): OrderStatus
  {
    return $this->status;
  }

  public function total(): Money
  {
    return $this->total;
  }

  public function expiresAt(): DateTimeImmutable
  {
    return $this->expiresAt;
  }
}