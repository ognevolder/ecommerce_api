<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view the Order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id
            || $user->isAdmin()
            || $user->isManager();
    }

    /**
     * Determine whether the user can create Orders.
     */
    public function create(User $user): bool
    {
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can update the Order status.
     */
    public function updateStatus(User $user): bool
    {
        return $user->isManager();
    }

    /**
     * Determine whether the user can cancel the Order.
     */
    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->user_id
            && $order->status !== OrderStatus::Fulfilled
            && $order->status !== OrderStatus::Canceled;
    }
}
