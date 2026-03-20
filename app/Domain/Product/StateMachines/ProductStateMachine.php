<?php

namespace App\Domain\Product\StateMachines;

use App\Domain\Product\Enums\ProductStatus;
use App\Domain\Product\Models\Product;
use App\Exceptions\ApiException;

class ProductStateMachine
{
  // --- Мапа дозволених переходів. | Allowed transition map.
  private array $transitions = [
    // Draft
    ProductStatus::DRAFT->value => [ProductStatus::PUBLIC->value],
    // Public
    ProductStatus::PUBLIC->value => [
      ProductStatus::DRAFT->value,
      ProductStatus::ARCHIVED->value
      ],
    // Archived
    ProductStatus::ARCHIVED->value => [ProductStatus::DRAFT]
  ];

  // --- Конструктор. | Builder.
  public function __construct(
    private Product $product
  ) {}

  /**
   * --- Запит на право. | Permission request.
   *
   * @param ProductStatus $newStatus
   * @return boolean
   */
  public function canTransitionTo(ProductStatus $newStatus): bool
  {
    $currentStatus = $this->product->status->value;
    $allowed = $this->transitions[$currentStatus] ?? [];
    return in_array($newStatus->value, $allowed);
  }

  public function transitionTo(ProductStatus $newStatus): void
  {
    $transitionRequest = $this->canTransitionTo($newStatus);
    if (! $transitionRequest) {
      throw new ApiException(
        message: "Transition from {$this->product->status->value} to {$newStatus->value} is denied.");
    }
    $this->product->update([
      'status' => $newStatus
    ]);
  }
}