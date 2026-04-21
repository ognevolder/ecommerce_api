<?php

namespace App\Presentation\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
  public function toArray($request): array
  {
    return [
      'id' => $this->id,
      'customer_id' => $this->customer_id,
      'total_price' => $this->total_price,
      'status' => $this->status,
      'items' => OrderItemResource::collection($this->items),
    ];
  }
}