<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id'          => 'required|exists:customers,id',
            'discount'             => 'nullable|numeric',
            'products'             => 'required|array',
            'products.*.id'        => 'required|exists:products,id|distinct',
            'products.*.quantity'  => 'required|numeric',
        ];
    }
}
