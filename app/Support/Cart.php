<?php

namespace App\Support;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ProductVariant;

/**
 * Session-based shopping cart.
 * Keys are "productId" or "productId:variantId" → qty.
 */
class Cart
{
    /** @return array<string, int> */
    public static function items(): array
    {
        return session('cart', []);
    }

    public static function count(): int
    {
        return (int) array_sum(self::items());
    }

    public static function key(int $productId, ?int $variantId = null): string
    {
        return $variantId ? "{$productId}:{$variantId}" : (string) $productId;
    }

    private static function parseKey(string $key): array
    {
        [$pid, $vid] = array_pad(explode(':', $key), 2, null);
        return [(int) $pid, $vid !== null && $vid !== '' ? (int) $vid : null];
    }

    /** Available stock for a cart line. */
    private static function stockFor(int $productId, ?int $variantId): int
    {
        if ($variantId) {
            $v = ProductVariant::find($variantId);
            return $v && $v->product_id === $productId ? (int) $v->stock : 0;
        }
        $p = Product::find($productId);
        return $p ? (int) $p->stock : 0;
    }

    public static function add(int $id, int $qty = 1, ?int $variantId = null): void
    {
        $key = self::key($id, $variantId);
        $stock = self::stockFor($id, $variantId);
        if ($stock <= 0 && $variantId === null) {
            $p = Product::find($id);
            if (!$p || $p->stock <= 0) {
                return;
            }
            $stock = (int) $p->stock;
        }
        if ($stock <= 0) {
            return;
        }
        $cart = self::items();
        $cart[$key] = min(($cart[$key] ?? 0) + $qty, $stock);
        session(['cart' => $cart]);
    }

    public static function update(string $key, int $qty): void
    {
        $cart = self::items();
        [$pid, $vid] = self::parseKey($key);
        if (!isset($cart[$key]) && $qty > 0) {
            return;
        }
        if ($qty <= 0) {
            unset($cart[$key]);
        } else {
            $cart[$key] = min($qty, self::stockFor($pid, $vid) ?: $qty);
        }
        session(['cart' => $cart]);
    }

    public static function remove(string $key): void
    {
        $cart = self::items();
        unset($cart[$key]);
        session(['cart' => $cart]);
    }

    public static function clear(): void
    {
        session()->forget('cart');
        session()->forget('coupon');
    }

    /**
     * @return \Illuminate\Support\Collection<int, object{key: string, product: Product, variant: ?ProductVariant, qty: int, price: int}>
     */
    public static function lines()
    {
        $items = self::items();
        $pids = [];
        $vids = [];
        foreach (array_keys($items) as $key) {
            [$pid, $vid] = self::parseKey($key);
            $pids[] = $pid;
            if ($vid) {
                $vids[] = $vid;
            }
        }
        $products  = Product::with('category')->whereIn('id', array_unique($pids))->get()->keyBy('id');
        $variants  = $vids ? ProductVariant::whereIn('id', array_unique($vids))->get()->keyBy('id') : collect();

        $lines = [];
        foreach ($items as $key => $qty) {
            [$pid, $vid] = self::parseKey($key);
            if (!isset($products[$pid])) {
                continue;
            }
            $variant = $vid && isset($variants[$vid]) && $variants[$vid]->product_id === $pid ? $variants[$vid] : null;
            $price   = $products[$pid]->price + ($variant ? $variant->price_delta : 0);
            $lines[] = (object) [
                'key'     => (string) $key,
                'product' => $products[$pid],
                'variant' => $variant,
                'qty'     => $qty,
                'price'   => $price,
            ];
        }
        return collect($lines);
    }

    public static function subtotal(): int
    {
        return (int) self::lines()->sum(fn ($l) => $l->price * $l->qty);
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
