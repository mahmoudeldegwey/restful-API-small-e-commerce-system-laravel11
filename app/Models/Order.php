<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany,HasMany};

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['order_number','total_price','product_count', 'user_id' ,'status'];

    public function products() : BelongsToMany {
        return $this->belongsToMany(Product::class,'order_products');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

}
