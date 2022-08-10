<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAddressRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'min:2|max:15',
            'number' => 'min:9|max:9',
            'country' => 'min:2|max:20',
            'city' => 'min:2|max:20',
            'street' => 'min:2|max:15',
            'zip' => 'min:4|max:4'
        ];
    }
}
