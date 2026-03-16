<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:96', 'unique:products,title'],
            'description' => ['required', 'string', 'unique:products,description'],
            'price' => ['required', 'numeric', 'decimal:2', 'gt:0'],
            'stock' => ['required', 'int', 'min:1']
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

            'price.required' => 'Price field is required.',
            'price.numeric' => 'Price field needs to be numeric value.',
            'price.decimal' => 'Only 2 decimals.',
            'price.gt' => 'Price needs to be greater than 0.',

            'stock.required' => 'Stock field is required.',
            'stock.int' => 'Stock field needs to be numeric value.',
            'stock.min' => 'Stock needs to be greater than 0.'
        ];
    }
}
