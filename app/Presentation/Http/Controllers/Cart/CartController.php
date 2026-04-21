<?php

namespace App\Presentation\Http\Controllers\Cart;

use App\Module\Cart\Services\CartService;
use App\Presentation\Http\Resources\Cart\CartResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class CartController
{
  public function __construct(private CartService $service) {}

  public function __invoke($id): JsonResponse
  {
    $cart = $this->service->show($id);

    return ApiResponse::success(
      data: new CartResource($cart),
      message: "Customer Cart with selected id: [$id].",
      code: 200
    );
  }
}