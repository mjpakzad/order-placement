<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Product;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total_price'];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
