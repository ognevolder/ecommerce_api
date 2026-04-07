<?php

namespace App\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderFulfillAction
{
  public function execute(Order $order): Order
  {
    return DB::transaction(function () use ($order) {
      foreach ($order->items as $item)
      {
        $product = $item->product;

        $product->decrement('stock', $item->quantity);
        $product->decrement('reserved', $item->quantity);
      }

      $order->update(['status' => 'Fulfilled']);
      return $order->fresh()->load('items.product');
    });
  }
}