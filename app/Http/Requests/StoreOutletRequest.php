<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutletRequest extends FormRequest
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
            'name'=>'unique:outlets|required|max:100',
            'latitude' => 'required|max:100',
            'longitude' => 'required|max:100',
            'brand_id'=>'required|exists:brands,id'
        ];
    }
}
