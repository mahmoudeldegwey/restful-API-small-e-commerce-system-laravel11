<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Product;

class OrderRequest extends ApiRequest
{

    public function rules(): array
    {
        // var_dump($this->products);
        // die;
        return [
            'products' => 'required|array',
            'products.*.product_id' => ['required',Rule::exists(Product::class, 'id')],
            'products.*.quantity' => [ 'required','integer','min:1', 

                //check product quantity is avaliable
                function ($attribute, $value, $fail){

                    $index = explode('.', $attribute)[1];
                    $product_id = $this->products[$index]['product_id'];
                    
                    $product = Product::find($product_id);

                    if($value >= $product->quantity){
                        $fail("$attribute ". $value ." quantity is not avaliable!");            
                    }
                            
                }
            ],
            'products.*.price' => 'required',
        ];
    }

    
}


