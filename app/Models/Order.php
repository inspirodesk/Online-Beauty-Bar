<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'woocommerce_id',
        'status',
        'total',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'shipping_email',
        'shipping_phone',
        'payment_method_title',
        'name',
        'permalink',
        'number',
        'created_via',
        'line_items',
    ];

    protected $casts = [
        'line_items' => 'array', // Cast JSON to array
        'created_via' => 'datetime', // Cast to Carbon instance
    ];

}
