<?php

namespace App\Actions\Order;

use App\Models\Order;
use Illuminate\Support\Collection;

class ItemInitializationAction
{
  /**
   * Створення order_items та підрахунок загальної суми | OrderItems and total value
   *
   * @param Order $order
   * @param Collection $products
   * @param array $items
   * @return float $total
   */
  public function execute(Order $order, Collection $products, array $items): float
  {
    $total = 0;
    $orderItems = [];

    foreach ($items as $item) {
        $product = $products[$item['product_id']];
        $totalPrice = $product->price * $item['quantity'];

        $orderItems[] = [
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'price' => $product->price,
            'total_price' => $totalPrice,
        ];

        $total += $totalPrice;
    }

    $order->items()->createMany($orderItems);

    return $total;
    }
}