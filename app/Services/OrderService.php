<?php

namespace App\Services;

use App\Actions\Order\InventoryCheckAction;
use App\Actions\Order\ItemInitializationAction;
use App\Actions\Order\OrderCreationAction;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
  public function __construct(
    private InventoryCheckAction $check,
    private OrderCreationAction $order,
    private ItemInitializationAction $item
  )
  {}

  /**
   * Створення Order | Order creation
   *
   * @param User $user
   * @param array $items [['product_id' => 5, 'quantity' => 5], ...]
   * @return \App\Models\Order
   * @throws \App\Exceptions\ApiException
   */
  public function create(User $user, array $items): Order
  {
    return DB::transaction(function () use ($user, $items)
    {
      // Перевірка та бронювання | Availability Check and Reservation
      // Return array $products
      $products = $this->check->execute($items);

      // Створення нульового Order | Empty order creation
      // Return Order $order
      $order = $this->order->execute($user);

      // OrderItems & total_price
      // Return OrderItem $item & float $total
      $total = $this->item->execute($order, $products, $items);

      // Оновлення total_price в Order
      // Return Order 'total_price'
      $order->update(['total_price' => $total]);

      // Завантаження повʼязаних OrderItems | OrderItems eager loading
      // Return Order & OrderItems
      $order->load('items.product');

      // Return Order
      return $order;
    });
  }
}