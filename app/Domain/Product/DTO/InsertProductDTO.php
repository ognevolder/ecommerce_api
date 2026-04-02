<?php

namespace App\Domain\Product\DTO;

class InsertProductDTO
{
  public function __construct(
    public string $title,
    public string $description,
    public int $quantity,
    public float $price,
    public int $admin_id
  ) {}
}