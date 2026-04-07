<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Order\Entities\Order;
use App\Domain\Order\Exceptions\OrderNotFoundException;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\ValueObjects\Money;
use App\Infrastructure\Persistence\Eloquent\Models\OrderModel;
use DateTimeImmutable;

class EloquentOrderRepository implements OrderRepositoryInterface
{
  private function toEntity(OrderModel $model): Order
  {
    return new Order(
      id: $model->id,
      customerId: $model->customer_id,
      status: $model->status,
      total: new Money($model->total_price, $model->currency),
      expiresAt: new DateTimeImmutable($model->expires_at)
    );
  }

  private function toModel(Order $order): OrderModel
  {
    $model = new OrderModel();
    $model->id = $order->id();
    $model->customer_id = $order->customerId();
    $model->total_price = $order->total()->amount();
    $model->currency = $order->total()->currency();
    $model->status = $order->status();
    $model->expires_at = $order->expiresAt();
    return $model;
  }

  public function findById(int $id): Order
  {
    $model = OrderModel::where('id', $id)->first();
    if (! $model) {
      throw new OrderNotFoundException($id);
    }
    return $this->toEntity($model);
  }

  public function save(Order $order): void
  {
    $model = $this->toModel($order);
    $model->save();
  }
}