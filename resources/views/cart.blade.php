@extends('layouts.app')

@section('title', __('messages.cart_title'))

@section('meta_desc'){{ __('messages.meta_default_desc') }}@endsection
@php($robots = 'noindex, nofollow')

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>{{ __('messages.cart_title') }}</h1></div>

    @if(\App\Support\Cart::count() === 0)
        <div class="empty-state reveal">
            <div class="ic">🛍️</div>
            <h3>{{ __('messages.cart_empty') }}</h3>
            <a class="btn btn-green" href="{{ route('shop') }}">{{ __('messages.cart_empty_cta') }}</a>
        </div>
    @else
        <div class="cart-layout">
            <div class="cart-list">
                @foreach(\App\Support\Cart::lines() as $line)
                    <div class="cart-item reveal">
                        <img src="{{ asset($line->product->image) }}" alt="{{ $line->product->name }}">
                        <div>
                            <h4><a href="{{ route('product', $line->product->id) }}">{{ $line->product->name }}@if($line->variant) <small style="color:var(--muted)">({{ $line->variant->name }})</small>@endif</a></h4>
                            <div class="meta">{{ $line->product->category->name }} — @price($line->price) {{ \App\Support\Fmt::toman() }}</div>
                            <form method="POST" action="{{ route('cart.update') }}" style="margin-top:9px">
                                @csrf
                                <div class="qty-control">
                                    <button type="submit" name="qty[{{ $line->key }}]" value="{{ $line->qty - 1 }}">−</button>
                                    <input name="qty[{{ $line->key }}]" value="{{ $line->qty }}" inputmode="numeric" onchange="this.form.submit()">
                                    <button type="submit" name="qty[{{ $line->key }}]" value="{{ $line->qty + 1 }}">+</button>
                                </div>
                            </form>
                        </div>
                        <div class="cart-item-side">
                            <div class="price">@price($line->price * $line->qty) <small>{{ \App\Support\Fmt::toman() }}</small></div>
                            <form method="POST" action="{{ route('cart.remove', $line->key) }}">
                                @csrf
                                <button class="remove-btn">✕ {{ __('messages.remove') }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <a class="btn btn-outline" href="{{ route('shop') }}" style="align-self:flex-start">← {{ __('messages.continue') }}</a>
            </div>

            <div class="summary-card reveal">
                <h3>{{ __('messages.order_summary') }}</h3>
                <div class="coupon-box">
                    @if(\App\Support\Cart::coupon())
                        <div class="coupon-applied">
                            🏷️ <b dir="ltr">{{ \App\Support\Cart::coupon()->code }}</b>
                            <form method="POST" action="{{ route('cart.coupon.remove') }}" style="display:inline">@csrf
                                <button class="mini-btn danger">{{ __('messages.coupon_remove') }}</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('cart.coupon') }}" class="coupon-form">
                            @csrf
                            <input name="code" placeholder="{{ __('messages.coupon_placeholder') }}" dir="ltr" required>
                            <button class="mini-btn">{{ __('messages.coupon_apply') }}</button>
                        </form>
                    @endif
                </div>
                <div class="summary-row"><span>{{ __('messages.subtotal') }}</span><b>@price(\App\Support\Cart::subtotal()) {{ \App\Support\Fmt::toman() }}</b></div>
                @if(\App\Support\Cart::discount() > 0)
                    <div class="summary-row discount"><span>{{ __('messages.discount') }} ({{ \App\Support\Cart::coupon()->code }})</span>
                        <b>- @price(\App\Support\Cart::discount()) {{ \App\Support\Fmt::toman() }}</b></div>
                @endif
                <div class="summary-row"><span>{{ __('messages.shipping') }}</span><b>{{ \App\Support\Cart::shipping() === 0 ? __('messages.shipping_free') : \App\Support\Fmt::price(\App\Support\Cart::shipping()) . ' ' . \App\Support\Fmt::toman() }}</b></div>
                <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price(\App\Support\Cart::total()) {{ \App\Support\Fmt::toman() }}</span></div>
                <a class="btn btn-primary btn-block" href="{{ route('checkout') }}">{{ __('messages.checkout') }} →</a>
            </div>
        </div>
    @endif
</div>
@endsection
