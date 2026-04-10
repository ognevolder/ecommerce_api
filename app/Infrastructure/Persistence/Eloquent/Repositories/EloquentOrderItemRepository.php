<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Order\Entities\OrderItem;
use App\Domain\Order\Repositories\OrderItemRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\OrderItemModel;

class EloquentOrderItemRepository implements OrderItemRepositoryInterface
{
  private function toModel(OrderItem $item): OrderItemModel
  {
    $model = new OrderItemModel();
    $model->order_id = $item->orderId();
    $model->product_id = $item->productId();
    $model->price = $item->price()->amount();
    $model->quantity = $item->quantity();
    return $model;
  }

  public function save(OrderItem $item): void
  {
    $model = $this->toModel($item);
    $model->save();
  }

  public function saveAll(array $orderItems): void
  {
    $data = array_map(fn($item) => [
      'order_id' => $item->orderId(),
      'product_id' => $item->productId(),
      'price' => $item->price()->amount(),
      'quantity' => $item->quantity()
    ], $orderItems);

    OrderItemModel::insert($data);
  }
}