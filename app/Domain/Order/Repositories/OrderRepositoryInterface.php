<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Order\Entities\Order;

interface OrderRepositoryInterface
{
  public function findById(int $id): Order;
  public function save(Order $order): void;
}