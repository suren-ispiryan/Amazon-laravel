<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:15',
            'description' => 'required|min:15|max:255',
            'brand' => 'required|min:3|max:25',
            'price' => 'required|numeric|digits_between:1,5',
            'color' => 'required|min:2|max:15',
            'size' => 'required|min:2|max:15',
            'category' => 'required|min:2|max:15',
            'in_stock' => 'required|numeric|digits_between:1,3'
        ];
    }
}
