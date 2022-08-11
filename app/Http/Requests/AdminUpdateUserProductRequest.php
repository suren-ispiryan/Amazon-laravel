<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserProductRequest extends FormRequest
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
            'description' => 'min:10|max:255',
            'brand' => 'min:5|max:25',
            'price' => 'numeric|digits_between:1,5',
            'color' => 'min:2|max:15',
            'size' => 'min:2|max:15',
            'category' => 'min:2|max:15',
            'in_stock' => 'numeric|digits_between:1,5'
        ];
    }
}
