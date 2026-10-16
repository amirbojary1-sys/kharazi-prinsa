<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /** Hosted demo gateway page (only used in demo mode). */
    public function show(string $code)
    {
        $order = Order::where('code', $code)->firstOrFail();

        if ($order->status !== 'pending' || $order->pay_method !== 'online') {
            return redirect()->route('order.success', $order->code);
        }
        if (PaymentGateway::mode() !== 'demo') {
            return redirect()->to(PaymentGateway::start($order));
        }

        return view('payment.gateway', compact('order'));
    }

    /** Gateway callback (demo POST or ZarinPal redirect with Authority/Status). */
    public function callback(Request $request, string $code)
    {
        $order = Order::where('code', $code)->firstOrFail();

        if ($order->status === 'paid') {
            return redirect()->route('order.success', $order->code);
        }

        // ZarinPal-style query params OR demo form fields
        $status = $request->input('Status', $request->input('status'));
        $ok     = in_array($status, ['OK', 'ok', 'success'], true);
        $refId  = $request->input('ref_id') ?: $request->input('Authority');

        $paid = PaymentGateway::settle($order, $ok, $refId, $request->input('card_pan'));

        if ($paid) {
            return redirect()->route('order.success', $order->code)->with('paid_ref', $order->ref_id);
        }
        return redirect()->route('order.success', $order->code)->with('error', __('messages.pay_failed'));
    }
}
