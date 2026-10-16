<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'code', 'customer_name', 'phone', 'email', 'address', 'city', 'zip', 'notes',
        'pay_method', 'status', 'subtotal', 'shipping', 'discount', 'coupon_code', 'total',
        'ref_id', 'card_pan', 'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function nextCode(): string
    {
        $n = 1000 + (int) static::count() + 1;
        return 'PR-' . $n;
    }
}
