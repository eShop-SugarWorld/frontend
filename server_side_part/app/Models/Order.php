<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'promocode_id',
        'ship_adr_id',
        'shipping_method',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'ship_adr_id');
    }

    public function promocode()
    {
        return $this->belongsTo(PromoCode::class, 'promocode_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}