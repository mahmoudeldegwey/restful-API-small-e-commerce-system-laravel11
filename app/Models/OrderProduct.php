<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    protected $fillable = ['order_id','product_id','product_quantity'];

    public function order(){
        return $this->belongs(Order::class,'order_id');
    }

    public function product(){
        return $this->belongs(Product::class,'product_id');
    }

}
