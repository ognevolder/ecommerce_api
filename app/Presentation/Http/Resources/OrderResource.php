<?php

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'created_at' => $this->created_at->format('d-m-Y H:i'),
      'updated_at' => $this->updated_at->format('d-m-Y H:i'),
      'total_price' => $this->total_price,
      'status' => $this->status,
      'items' => OrderItemResource::collection(
          $this->whenLoaded('items')
      ),
    ];
  }
}
