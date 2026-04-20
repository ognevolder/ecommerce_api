<?php

namespace App\Presentation\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class RemoveCartItemsRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'product_id' => ['required', 'integer', 'exists:products,id'],
      'quantity' => ['nullable', 'integer', 'min:1']
    ];
  }
}