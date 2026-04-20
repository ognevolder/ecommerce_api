<?php

namespace App\Presentation\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'product_id' => ['required', 'int', 'distinct', 'exists:products,id'],
      'quantity' => ['required', 'int', 'min:1']
    ];
  }
}