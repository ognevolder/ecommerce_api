<?php

namespace App\Presentation\Http\Controllers\Cart;

use App\Module\Cart\DTOs\CartServiceDTO;
use App\Module\Cart\Services\CartService;
use App\Module\Product\Shared\ProductDomainException;
use App\Presentation\Http\Requests\Cart\CartRequest;
use App\Presentation\Http\Resources\Cart\CartResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class AddCartItemsController
{
  public function __construct(private CartService $service) {}

  public function __invoke(CartRequest $request): JsonResponse
  {
    $user = $request->user();

    $dto = new CartServiceDTO(
        product_id: $request->input('product_id'),
        quantity: $request->input('quantity'),
        user_id: $user->id
    );

    try {
      $cart = $this->service->add($dto);
    } catch (ProductDomainException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    return ApiResponse::success(
        data: new CartResource($cart),
        message: "Cart updated",
        code: 200
    );
  }
}