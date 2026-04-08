<?php

namespace App\Domain\Order\Entities;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\ValueObjects\Money;
use DateTimeImmutable;

class Order
{
  public function __construct(
    private readonly ?int $id,
    private readonly int $customerId,
    private readonly OrderStatus $status,
    private readonly Money $total,
    private readonly DateTimeImmutable $expiresAt
  ) {}

  public function id(): int
  {
    return $this->id;
  }

  public function customerId(): ?int
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