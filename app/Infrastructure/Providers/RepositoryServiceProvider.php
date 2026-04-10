<?php

namespace App\Infrastructure\Providers;

use App\Domain\Order\Repositories\OrderItemRepositoryInterface;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentOrderItemRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentOrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    $this->app->bind(
      abstract: OrderRepositoryInterface::class,
      concrete: EloquentOrderRepository::class
    );

    $this->app->bind(
      abstract: OrderItemRepositoryInterface::class,
      concrete: EloquentOrderItemRepository::class
    );
  }
}