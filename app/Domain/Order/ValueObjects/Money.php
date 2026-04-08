<?php

namespace App\Domain\Order\ValueObjects;

class Money
{
  public function __construct(private readonly int $amount) {}

  public function amount(): int
  {
    return $this->amount;
  }

  public function add(Money $addend): self
  {
    return new self($this->amount + $addend->amount);
  }

  public function subtract(Money $charge): self
  {
    return new self($this->amount - $charge->amount);
  }
}