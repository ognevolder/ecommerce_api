<?php

namespace App\Domain\Order\Entities;

use App\Domain\Order\ValueObjects\Money;

class OrderItem
{
  public function __construct(
    private readonly ?int $id,
    private readonly int $orderId,
    private readonly int $productId,
    private readonly Money $price,
    private readonly int $quantity
  ) {}

  public function id(): int
  {
    return $this->id;
  }

  public function orderId(): int
  {
    return $this->orderId;
  }

  public function productId(): int
  {
    return $this->productId;
  }

  public function price(): Money
  {
    return $this->price;
  }

  public function quantity(): int
  {
    return $this->quantity;
  }

  public function total(): Money
  {
    return new Money($this->price->amount() * $this->quantity);
  }
}