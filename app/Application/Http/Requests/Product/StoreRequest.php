<?php

namespace App\Application\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'title' => ['required', 'string', 'max:96', 'unique:products,title'],
      'description' => ['required', 'string', 'unique:products,description'],
      'quantity' => ['required', 'int', 'min:1'],
      'price' => ['required', 'numeric', 'decimal:2', 'gt:0'],
      'status' => ['required']
    ];
  }

  public function messages(): array
  {
    return [
      'title.required' => 'Title field is required.',
      'title.max' => 'Title limit is reached.',
      'title.unique' => 'Item with this title exists.',

      'description.required' => 'Description field is required.',
      'description.unique' => 'Description with this values exists.',

      'quantity.required' => 'Stock field is required.',
      'quantity.int' => 'Stock field needs to be numeric value.',
      'quantity.min' => 'Stock needs to be greater than 0.',

      'price.required' => 'Price field is required.',
      'price.numeric' => 'Price field needs to be numeric value.',
      'price.decimal' => 'Only 2 decimals.',
      'price.gt' => 'Price needs to be greater than 0.'
    ];
  }
}