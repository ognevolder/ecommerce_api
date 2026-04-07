<?php

namespace App\Domain\Order\ValueObjects;

class Money
{
  public function __construct(
    private readonly int $amount,
    private readonly string $currency
  ) {}

  public function amount(): int
  {
    return $this->amount;
  }

  public function currency(): string
  {
    return $this->currency;
  }

  public function add(Money $addend): self
  {
    return new self($this->amount + $addend->amount, $this->currency);
  }
}