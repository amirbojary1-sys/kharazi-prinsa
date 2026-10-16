<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_amount', 'max_uses', 'used_count', 'expires_at', 'active',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'active'     => 'boolean',
    ];

    /** Validate + compute discount for a given subtotal. Returns [discount, errorKey]. */
    public function applyTo(int $subtotal): array
    {
        if (!$this->active) {
            return [0, 'coupon_invalid'];
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return [0, 'coupon_expired'];
        }
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return [0, 'coupon_used_up'];
        }
        if ($subtotal < $this->min_amount) {
            return [0, 'coupon_min'];
        }

        $discount = $this->type === 'percent'
            ? (int) round($subtotal * $this->value / 100)
            : (int) $this->value;

        return [min($discount, $subtotal), null];
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', trim($code))->first();
    }
}
