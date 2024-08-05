<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'address',
        'contact_number',
        'whatsapp_number',
        'order_no',
        'track_no',
        'payment_method',
        'status',
        'delivery_status',
        'discount',
        'subtotal',
        'final_total',
        'attachment',
        'block_status'
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'final_total' => 'decimal:2',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
