<?php

namespace App\Presentation\Http\Resources\Order;

use App\Presentation\Http\Resources\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
  public function toArray($request): array
  {
    return [
      'items' => ProductResource::collection($this->items)
    ];
  }
}