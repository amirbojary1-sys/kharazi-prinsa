<?php

namespace App\Support;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;

/**
 * Session-based shopping cart: [product_id => qty] + coupon session key.
 */
class Cart
{
    public static function items(): array
    {
        return session('cart', []);
    }

    public static function count(): int
    {
        return (int) array_sum(self::items());
    }

    public static function add(int $id, int $qty = 1): void
    {
        $cart = self::items();
        $product = Product::find($id);
        if (!$product || $product->stock <= 0) {
            return;
        }
        $cart[$id] = min(($cart[$id] ?? 0) + $qty, $product->stock);
        session(['cart' => $cart]);
    }

    public static function update(int $id, int $qty): void
    {
        $cart = self::items();
        $product = Product::find($id);
        if (!$product) {
            return;
        }
        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = min($qty, $product->stock);
        }
        session(['cart' => $cart]);
    }

    public static function remove(int $id): void
    {
        $cart = self::items();
        unset($cart[$id]);
        session(['cart' => $cart]);
    }

    public static function clear(): void
    {
        session()->forget('cart');
        session()->forget('coupon');
    }

    /** @return \Illuminate\Support\Collection<int, object{product: Product, qty: int}> */
    public static function lines()
    {
        $ids = array_keys(self::items());
        $products = Product::with('category')->whereIn('id', $ids)->get()->keyBy('id');
        $lines = [];
        foreach (self::items() as $id => $qty) {
            if (isset($products[$id])) {
                $lines[] = (object) ['product' => $products[$id], 'qty' => $qty];
            }
        }
        return collect($lines);
    }

    public static function subtotal(): int
    {
        return (int) self::lines()->sum(fn ($l) => $l->product->price * $l->qty);
    }

    /* ------------------------------- coupon ------------------------------- */

    public static function coupon(): ?Coupon
    {
        $code = session('coupon');
        return $code ? Coupon::findByCode($code) : null;
    }

    /** @return array{ok: bool, msg: string} */
    public static function applyCoupon(string $code): array
    {
        $coupon = Coupon::findByCode($code);
        if (!$coupon) {
            return ['ok' => false, 'msg' => __('messages.coupon_invalid')];
        }
        [$discount, $err] = $coupon->applyTo(self::subtotal());
        if ($err) {
            return ['ok' => false, 'msg' => __('messages.' . $err)];
        }
        session(['coupon' => $coupon->code]);
        return ['ok' => true, 'msg' => __('messages.coupon_applied')];
    }

    public static function removeCoupon(): void
    {
        session()->forget('coupon');
    }

    public static function discount(): int
    {
        $coupon = self::coupon();
        if (!$coupon) {
            return 0;
        }
        [$discount, $err] = $coupon->applyTo(self::subtotal());
        return $err ? 0 : $discount;
    }

    /* ------------------------------- totals ------------------------------- */

    public static function shipping(): int
    {
        $sub = self::subtotal() - self::discount();
        $freeMin = (int) Setting::get('free_ship_min');
        $cost    = (int) Setting::get('shipping_cost');
        return ($sub === 0 || $sub >= $freeMin) ? 0 : $cost;
    }

    public static function total(): int
    {
        return max(0, self::subtotal() - self::discount()) + self::shipping();
    }
}
