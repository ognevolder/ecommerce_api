<?php

namespace App\Presentation\Http\Resources\Cart;

use App\Presentation\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'product' => new ProductResource($this->product),
      'price' => $this->price,
      'quantity' => $this->quantity,
      'total' => $this->total
    ];
  }
}