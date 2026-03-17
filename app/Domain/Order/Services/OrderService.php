<?php

namespace App\Services;

use App\Actions\Order\InventoryCheckAction;
use App\Actions\Order\ItemInitializationAction;
use App\Actions\Order\OrderCancelationAction;
use App\Actions\Order\OrderCreationAction;
use App\Actions\Order\OrderFulfillAction;
use App\Exceptions\ApiException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderService
{
  public function __construct(
    private InventoryCheckAction $check,
    private OrderCreationAction $order,
    private ItemInitializationAction $item,
    private OrderCancelationAction $cancelation,
    private OrderFulfillAction $fulfill
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

  public function fulfill(int $order_id): Order
  {
    $order = Order::with('items.product')
      ->where('id', $order_id)
      ->lockForUpdate()
      ->firstOrFail();

    if ($order->status === 'Fulfilled')
    {
      throw new ApiException($order, 'Неможливо виконати дію.', 422);
    }

    return $this->fulfill->execute($order);
  }


  public function cancel(int $user_id, int $order_id): Order
  {
    // Fetch Order
    $order = Order::with('items.product')
      ->where('id', $order_id)
      ->lockForUpdate()
      ->firstOrFail();
    // Fetch User
    $user = User::findOrFail($user_id);
    // Автентифікація користувача | User auth check
    if ($order->user_id !== $user_id && $user->role !== 'admin')
    {
      throw new ApiException($order, 'Неможливо виконати дію.', 401);
    }

    if ($order->status === 'Canceled')
    {
      throw new ApiException($order, 'Неможливо виконати дію.', 422);
    }

    // Service
    return DB::transaction(function () use ($order)
    {
      // Cancel reservation
      foreach ($order->items as $item)
      {
        $product = $item->product;
        $product->decrement('reserved', $item->quantity);
      }

      $order->update([
        'status' => 'Canceled'
      ]);

      // Response
      return $order->fresh()->load('items.product');
    });
  }
}