<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
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
            'page_size' => 'integer|between:10,50',
            'page' => 'integer',
            'order_by' => 'string|in:name,price',
            'order' => 'string|in:asc,desc',
            'price_min' => 'integer|min:0',
            'price_max' => 'string|min:0',
            'name' => 'string',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id'
        ];
    }
}
