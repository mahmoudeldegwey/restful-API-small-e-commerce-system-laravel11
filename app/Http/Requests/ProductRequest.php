<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ];
    }
}
