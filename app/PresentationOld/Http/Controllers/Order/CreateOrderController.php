<?php

namespace App\Presentation\Http\Controllers\Order;

use App\Application\Order\DTO\CreateOrderDTO;
use App\Application\Order\Services\OrderService;
use App\Domain\Order\Entities\Order;
use App\Presentation\Http\Requests\StoreOrderRequest;
use App\Presentation\Http\Resources\OrderResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CreateOrderController
{
  public function __construct(private OrderService $service) {}

  public function create(StoreOrderRequest $request): JsonResponse
  {
    // Policy.
    Gate::authorize('create', Order::class);
    // DTO.
    $dto = new CreateOrderDTO(
      customerId: Auth::user()->id,
      items: $request->product_items
    );
    // Service.
    $order = $this->service->create($dto);
    // Response.
    return ApiResponse::success(
      data: new OrderResource($order),
      message: "Order created successfuly.",
      code: 201
    );
  }
}