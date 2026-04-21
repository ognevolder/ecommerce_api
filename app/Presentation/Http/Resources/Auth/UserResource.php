<?php

namespace App\Presentation\Http\Resources\Auth;

use App\Presentation\Http\Resources\Cart\CartResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'name' => $this->name,
      'email' => $this->email,
      'role' => $this->role->label(),
      'cart' => new CartResource($this->cart)
      ];
  }
}