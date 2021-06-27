<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommerceRequest extends FormRequest
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
            'fullname' => 'required|string|max:50',
            'whatsapp_number' => 'nullable|string|max:20',
            'instagram_account' => 'nullable|string|max:30',
            'currency.id' => 'required|exists:currencies,id',
            'cover_dirname' => 'nullable|url',
            'avatar_dirname' => 'nullable|url',
            'has_action_buttons' => 'boolean',
            'has_footer' => 'boolean',
        ];
    }
}
