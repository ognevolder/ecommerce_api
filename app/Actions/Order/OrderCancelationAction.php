<?php

namespace App\Actions\Order;

use App\Models\Order;

class OrderCancelationAction
{
  public function execute(Order $order): Order
  {
    // Зміна статуса | Status changing
    $order->update([
      'status' => 'Canceled'
    ]);
    // Return refreshed Order
    return $order->fresh()->load('items.product');
  }
}