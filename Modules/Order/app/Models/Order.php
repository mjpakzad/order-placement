<?php

namespace Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Models\User;
use Modules\Order\Database\Factories\OrderFactory;
use Modules\Order\Enums\OrderStatus;
use Modules\Order\Enums\ShippingMethod;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'products_total_price',
        'total_price',
        'shipping_method',
        'shipping_cost',
        'status',
    ];

     protected static function newFactory(): OrderFactory
     {
         return OrderFactory::new();
     }

    protected $casts = [
        'shipping_method' => ShippingMethod::class,
        'status' => OrderStatus::class,
    ];

    public function getShippingMethodLabelAttribute(): string
    {
        return $this->shipping_method->label();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
