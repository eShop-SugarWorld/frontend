<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $table = 'shipping_address';
    protected $fillable = [
        'country',
        'street_adr',
        'city',
        'region',
        'postal_code',
    ];
}