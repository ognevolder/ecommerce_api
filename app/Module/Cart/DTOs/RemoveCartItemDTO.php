<?php

namespace App\Module\Cart\DTOs;

class RemoveCartItemDTO
{
  public function __construct(
    public int $product_id,
    public ?int $quantity,
    public int $user_id
  ) {}
}