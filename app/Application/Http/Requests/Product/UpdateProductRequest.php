<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:96'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'decimal:2', 'gt:0'],
            'stock' => ['required', 'int', 'min:1']
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'Title field is required.',
            'title.max' => 'Title limit is reached.',

            'description.required' => 'Description field is required.',

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
