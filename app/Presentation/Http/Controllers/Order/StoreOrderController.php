<?php

namespace App\Presentation\Http\Controllers\Order;

use App\Module\Order\Exceptions\EmptyCartException;
use App\Module\Order\Services\OrderService;
use App\Presentation\Http\Resources\Order\OrderResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreOrderController
{
  public function __construct(
      private OrderService $service
  ) {}

  public function __invoke(Request $request): JsonResponse
  {
    try {
      $order = $this->service->store(
          $request->user()->id
      );
    } catch (EmptyCartException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    return ApiResponse::success(
        data: new OrderResource($order),
        message: 'Order created from cart',
        code: 201
    );
  }
}