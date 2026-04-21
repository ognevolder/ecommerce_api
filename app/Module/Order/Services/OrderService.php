<?php

namespace App\Module\Order\Services;

use App\Module\Cart\Models\Cart;
use App\Module\Order\Enums\OrderStatus;
use App\Module\Order\Exceptions\EmptyCartException;
use App\Module\Order\Models\Order;
use App\Module\Order\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
  public function store(int $user_id): Order
  {
    return DB::transaction(function () use ($user_id)
    {
      // Fetch Cart.
      $cart = Cart::where('user_id', $user_id)
        ->lockForUpdate()
        ->with('items.product')
        ->first();

      if ($cart->items->isEmpty()) {
        throw new EmptyCartException();
      }

      // Create empty Order
      $order = Order::create([
        'user_id' => $user_id,
        'total' => 0,
        'status' => OrderStatus::New,
        'expires_at' => now()->addMinutes(15)
      ]);

      $total = 0;

      // Add items
      foreach ($cart->items as $item)
      {
        if ($item->product->stock < $item->quantity)
        {
          throw new \DomainException("Insufficient stock for product {$item->product_id}");
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'total' => $item->total,
        ]);

        $item->product->decrement('stock', $item->quantity);

        $total += $item->total;
      }

      // Order total
      $order->update([
          'total_price' => $total
        ]);

      // Clear cart
      $cart->items()->delete();

      // Return
      return $order->load('items.product');
    });
  }
}