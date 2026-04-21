<?php

namespace App\Module\Order\DTOs;

class OrderDTO
{
  public function __construct(public int $userId) {}
}