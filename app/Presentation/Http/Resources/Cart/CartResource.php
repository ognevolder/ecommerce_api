<?php

namespace App\Presentation\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'customer_id' => $this->user_id,
      'items' => CartItemResource::collection($this->items),
      'total' => $this->total
    ];
  }
}
