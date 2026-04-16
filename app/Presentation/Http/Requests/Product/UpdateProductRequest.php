<?php

namespace App\Presentation\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'title' => ['required', 'string', 'max:96'],
      'description' => ['required', 'string'],
      'quantity' => ['required', 'int', 'min:1'],
      'price' => ['required', 'int', 'gt:0']
    ];
  }

  public function messages(): array
  {
    return [
      'title.required' => 'Title field is required.',
      'title.max' => 'Title limit is reached.',
      'title.unique' => 'Item with this title exists.',

      'description.required' => 'Description field is required.',
      'description.unique' => 'Description with this value exists.',

      'quantity.required' => 'Stock field is required.',
      'quantity.int' => 'Stock field needs to be numeric value.',
      'quantity.min' => 'Stock needs to be greater than 0.',

      'price.required' => 'Price field is required.',
      'price.int' => 'Price field needs to be integer value (cents).',
      'price.gt' => 'Price needs to be greater than 0.'
    ];
  }
}
