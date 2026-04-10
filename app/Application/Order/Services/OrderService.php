<?php

namespace App\Application\Order\Services;

use App\Application\Order\DTO\CreateOrderDTO;
use App\Domain\Order\Entities\Order;
use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\ValueObjects\Money;

class OrderService
{
  public function __construct(private OrderRepositoryInterface $repo) {}

  public function create(CreateOrderDTO $dto): Order
  {
    $entity = new Order(
      id: null,
      customerId: $dto->customerId,
      status: OrderStatus::NEW,
      total: new Money(array_sum(array_column($dto->items, 'price'))),
      expiresAt: new \DateTimeImmutable('+15 minutes')
    );

    $this->repo->save($entity);

    return $entity;
  }
}