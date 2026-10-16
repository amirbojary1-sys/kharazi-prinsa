@extends('layouts.app')

@section('title', __('messages.order_success'))

@section('content')
<div class="container">
    <div class="success-wrap">
        <div class="success-icon">✓</div>
        <h1>{{ __('messages.order_success') }}</h1>
        <p style="color:var(--muted)">{{ __('messages.order_msg') }}</p>
        <div class="order-code">{{ __('messages.order_no') }}: {{ $order->code }}</div>
        @if($order->status === 'paid' && $order->ref_id)
            <div class="order-ref">🔑 {{ __('messages.tr_ref') }}: <b dir="ltr">{{ $order->ref_id }}</b>
                @if($order->card_pan) — 💳 <b dir="ltr">{{ $order->card_pan }}</b>@endif
            </div>
        @endif

        <div class="summary-card" style="text-align:start;max-width:480px;margin-inline:auto">
            <h3>{{ __('messages.order_summary') }}</h3>
            @foreach($order->items as $item)
                <div class="summary-row">
                    <span>{{ $item->name }} × @num($item->qty)</span>
                    <b>@price($item->price * $item->qty)</b>
                </div>
            @endforeach
            @if($order->discount)
                <div class="summary-row discount"><span>{{ __('messages.discount') }}@if($order->coupon_code) ({{ $order->coupon_code }})@endif</span><b>- @price($order->discount)</b></div>
            @endif
            <div class="summary-row"><span>{{ __('messages.shipping') }}</span><b>{{ $order->shipping === 0 ? __('messages.shipping_free') : \App\Support\Fmt::price($order->shipping) . ' ' . \App\Support\Fmt::toman() }}</b></div>
            <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price($order->total) {{ \App\Support\Fmt::toman() }}</span></div>
        </div>

        @if($order->status === 'pending' && $order->pay_method === 'online')
            <div class="order-ref" style="border-color:#c0392b;color:#c0392b;background:rgba(192,57,43,.07)">
                ⚠️ {{ __('messages.pay_failed') }}
                <a class="btn btn-green" style="margin-top:10px;display:inline-flex" href="{{ route('payment.show', $order->code) }}">{{ __('messages.pay_retry') }}</a>
            </div>
        @endif

        <div style="margin-top:28px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a class="btn btn-green" href="{{ route('home') }}">{{ __('messages.back_home') }}</a>
            <a class="btn btn-outline" href="{{ route('shop') }}">{{ __('messages.continue') }}</a>
        </div>
    </div>
</div>
@endsection
