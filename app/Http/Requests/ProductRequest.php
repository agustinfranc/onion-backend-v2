<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'max:255',
            'disabled' => 'boolean',
            'name' => 'required|max:255',
            'price' => 'nullable',
            'product_prices' => 'array',
            'product_hashtags' => 'array',
            'rubro.id' => 'required_without:subrubro.id|exists:rubros,id',
            'subrubro.id' => 'sometimes|required|exists:subrubros,id',
            'subrubro' => 'required_without:subrubro.id',
        ];
    }
}
