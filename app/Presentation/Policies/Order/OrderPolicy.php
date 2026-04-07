<?php

namespace App\Presentation\Policies;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Enums\OrderStatus;

class OrderPolicy
{
  public function viewAll(User $user): bool
  {
    return $user->isManager();
  }

  public function view(User $user, Order $order): bool
  {
    return $user->id === $order->customerId || $user->isManager();
  }

  public function store(User $user): bool
  {
    return $user->isCustomer();
  }

  public function update(User $user, Order $order): bool
  {
    return $user->id === $order->user_id;
  }

  public function cancel(User $user, Order $order): bool
  {
    return ($user->id === $order->user_id || $user->isManager())
      && $order->status !== OrderStatus::FULFILLED
      && $order->status !== OrderStatus::CANCELED;
  }

  public function updateStatus(User $user, Order $order): bool
  {
    return $user->isManager()
      && (
        $order->status === OrderStatus::NEW
        || $order->status === OrderStatus::PENDING
        );
  }
}