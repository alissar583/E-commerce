<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name'=>[],
            'price'=>[],
            'facebook_url'=>[],
            'whatsapp_url'=>[],
            'expired_date'=>[],
            'quantity'=>[],
            'owner_id'=>[],
            'category_id'=>[Rule::exists('categories', 'id')],
        ];

    }
}
