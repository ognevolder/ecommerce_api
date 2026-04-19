<?php

namespace App\Module\Product\StateMachines;

use App\Module\Product\Models\Product;
use App\Module\Product\Enums\ProductStatus;
use App\Module\Product\Exceptions\TransitionDeniedException;

class ProductStateMachine
{
  // --- Allowed transition map.
  private array $transitions = [
    // Draft
    ProductStatus::Draft->value => [ProductStatus::Public->value],
    // Public
    ProductStatus::Public->value => [
      ProductStatus::Draft->value,
      ProductStatus::Archived->value
      ],
    // Archived
    ProductStatus::Archived->value => []
  ];

  // --- Builder.
  public function __construct(
    private Product $product
  ) {}

  /**
   * --- Permission request.
   *
   * @param ProductStatus $newStatus
   * @return boolean
   */
  public function canTransitionTo(ProductStatus $newStatus): bool
  {
    $currentStatus = $this->product->status;
    $allowed = $this->transitions[$currentStatus] ?? [];
    return in_array($newStatus->value, $allowed);
  }

  public function transitionTo(ProductStatus $newStatus): void
  {
    $transitionRequest = $this->canTransitionTo($newStatus);
    if (! $transitionRequest) {
      throw new TransitionDeniedException(
        message: "Transition from {$this->product->status} to {$newStatus->value} is denied.");
    }
    $this->product->update([
      'status' => $newStatus
    ]);
  }
}