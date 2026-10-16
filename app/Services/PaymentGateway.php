<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

/**
 * Payment gateway facade.
 *
 *  - mode "demo"     : hosted demo gateway page (Shaparak-style) → callback
 *  - mode "zarinpal" : real ZarinPal v4 API (set gateway_merchant in admin settings)
 */
class PaymentGateway
{
    public static function mode(): string
    {
        return Setting::get('gateway_mode') ?: 'demo';
    }

    /** Begin payment for an order; returns the URL to redirect the customer to. */
    public static function start(Order $order): string
    {
        if (self::mode() === 'zarinpal') {
            $url = self::zarinpalStart($order);
            if ($url) {
                return $url;
            }
        }
        return route('payment.show', $order->code);
    }

    /** Verify + settle. Returns true when the order is marked paid. */
    public static function settle(Order $order, bool $success, ?string $refId, ?string $cardPan = null): bool
    {
        if (!$success) {
            // keep the order pending so the customer can retry payment from the order page
            return false;
        }

        if (self::mode() === 'zarinpal') {
            [$ok, $ref] = self::zarinpalVerify($order, (string) $refId);
            if (!$ok) {
                $order->status = 'cancelled';
                $order->save();
                return false;
            }
            $refId = $ref;
        }

        $order->status    = 'paid';
        $order->ref_id    = $refId ?: (string) random_int(1000000000, 9999999999);
        $order->card_pan  = $cardPan ?: '6037-****-****-' . random_int(1000, 9999);
        $order->paid_at   = now();
        $order->save();

        if ($order->coupon_code && ($coupon = \App\Models\Coupon::findByCode($order->coupon_code))) {
            $coupon->increment('used_count');
        }

        return true;
    }

    /* ------------------------------ ZarinPal ------------------------------ */

    private static function zarinpalStart(Order $order): ?string
    {
        $merchant = Setting::get('gateway_merchant');
        if (!$merchant) {
            return null;
        }
        try {
            $res = Http::timeout(15)->post('https://payment.zarinpal.com/pg/v4/payment/request.json', [
                'merchant_id'  => $merchant,
                'amount'       => $order->total * 10,       // Toman → Rial
                'description'  => "Order {$order->code} | Prinsa",
                'callback_url' => route('payment.callback', $order->code),
            ])->json();

            if (($res['data']['code'] ?? null) === 100 && !empty($res['data']['authority'])) {
                $order->ref_id = $res['data']['authority'];   // authority kept until verify
                $order->save();
                return 'https://payment.zarinpal.com/pg/StartPay/' . $res['data']['authority'];
            }
        } catch (\Throwable) {
            // fall through to demo
        }
        return null;
    }

    /** @return array{0: bool, 1: ?string} [verified, ref_id] */
    private static function zarinpalVerify(Order $order, string $authority): array
    {
        try {
            $res = Http::timeout(15)->post('https://payment.zarinpal.com/pg/v4/payment/verify.json', [
                'merchant_id' => Setting::get('gateway_merchant'),
                'amount'      => $order->total * 10,
                'authority'   => $authority,
            ])->json();

            if (in_array($res['data']['code'] ?? null, [100, 101], true)) {
                return [true, (string) ($res['data']['ref_id'] ?? $authority)];
            }
        } catch (\Throwable) {
        }
        return [false, null];
    }

    /** Demo reference generator (looks like a real Shaparak ref id). */
    public static function demoRef(): string
    {
        return (string) random_int(1000000000, 9999999999);
    }

    public static function demoPan(): string
    {
        return '6037-****-****-' . random_int(1000, 9999);
    }
}
