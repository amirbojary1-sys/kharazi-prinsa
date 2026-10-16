<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'name_fa', 'name_en', 'variant_name', 'price', 'qty', 'image',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute()
    {
        $base = app()->getLocale() === 'fa' ? $this->name_fa : $this->name_en;
        return $this->variant_name ? "{$base} ({$this->variant_name})" : $base;
    }
}
