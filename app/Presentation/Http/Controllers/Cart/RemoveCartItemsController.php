<?php

namespace App\Presentation\Http\Controllers\Cart;

use App\Module\Cart\DTOs\RemoveCartItemDTO;
use App\Module\Cart\Services\CartService;
use App\Presentation\Http\Requests\Cart\RemoveCartItemsRequest;
use App\Presentation\Http\Resources\Cart\CartResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class RemoveCartItemsController
{
  public function __construct(private CartService $service) {}

  public function __invoke(RemoveCartItemsRequest $request): JsonResponse
  {
    $dto = new RemoveCartItemDTO(
      product_id: $request->validated('product_id'),
      quantity: $request->validated('quantity'),
      user_id: $request->user()->id
    );

    $cart = $this->service->remove($dto);

    return ApiResponse::success(
      data: new CartResource($cart),
      message: 'Cart updated after removal',
      code: 200
    );
  }
}