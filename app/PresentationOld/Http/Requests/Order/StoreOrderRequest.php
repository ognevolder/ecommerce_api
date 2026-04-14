<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'product_items' => ['required', 'array', 'min:1'],
      'product_items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
      'product_items.*.quantity' => ['required', 'integer', 'min:1']
    ];
  }
}