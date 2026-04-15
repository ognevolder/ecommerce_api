<?php

namespace App\Presentation\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'title' => $this->title,
      'description' => $this->description,
      'price' => $this->price,
      'stock' => $this->availability(),
      'sold' => $this->sold
    ];
  }
}
