<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Entities\OrderItem;

interface OrderItemRepositoryInterface
{
  public function save(OrderItem $orderItem): void;
  public function saveAll(array $orderItems): void;
}