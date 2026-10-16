@extends('layouts.app')

@section('title', __('messages.checkout_title'))

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>{{ __('messages.checkout_title') }}</h1></div>

    <div class="cart-layout">
        <div class="form-card reveal">
            <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}" class="form-grid"
                  data-total="@price(\App\Support\Cart::total())"
                  data-currency="{{ \App\Support\Fmt::toman() }}">
                @csrf
                <div class="form-group"><label>{{ __('messages.f_name') }} <span class="req">*</span></label><input class="input" name="name" value="{{ old('name') }}" required></div>
                <div class="form-group"><label>{{ __('messages.f_phone') }} <span class="req">*</span></label><input class="input" name="phone" value="{{ old('phone') }}" inputmode="tel" required></div>
                <div class="form-group"><label>{{ __('messages.f_email') }}</label><input class="input" name="email" type="email" value="{{ old('email') }}"></div>
                <div class="form-group"><label>{{ __('messages.f_city') }} <span class="req">*</span></label><input class="input" name="city" value="{{ old('city') }}" required></div>
                <div class="form-group full"><label>{{ __('messages.f_address') }} <span class="req">*</span></label><input class="input" name="address" value="{{ old('address') }}" required></div>
                <div class="form-group"><label>{{ __('messages.f_zip') }}</label><input class="input" name="zip" value="{{ old('zip') }}" inputmode="numeric"></div>
                <div class="form-group"><label>{{ __('messages.f_notes') }}</label><input class="input" name="notes" value="{{ old('notes') }}"></div>

                <div class="form-group full">
                    <label>{{ __('messages.pay_title') }}</label>
                    <div class="pay-options">
                        <label class="pay-option selected">
                            <input type="radio" name="pay" value="online" checked>
                            <div><b>💳 {{ __('messages.pay_online') }}</b><span>{{ __('messages.pay_online_d') }}</span></div>
                        </label>
                        <label class="pay-option">
                            <input type="radio" name="pay" value="cod">
                            <div><b>📦 {{ __('messages.pay_cod') }}</b><span>{{ __('messages.pay_cod_d') }}</span></div>
                        </label>
                        <label class="pay-option">
                            <input type="radio" name="pay" value="card">
                            <div><b>🏦 {{ __('messages.pay_card') }}</b><span>{{ __('messages.pay_card_d') }}</span></div>
                        </label>
                    </div>
                    <div id="cardInfo" style="display:none;margin-top:10px;color:var(--muted);font-size:.85rem">{{ __('messages.card_example') }}</div>
                </div>

                <div class="form-group full">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('messages.place_order') }}</button>
                </div>
            </form>
        </div>

        <div class="summary-card reveal" data-delay="1">
            <h3>{{ __('messages.order_summary') }}</h3>
            @foreach(\App\Support\Cart::lines() as $line)
                <div class="summary-row">
                    <span>{{ $line->product->name }} × @num($line->qty)</span>
                    <b>@price($line->product->price * $line->qty)</b>
                </div>
            @endforeach
            @if(\App\Support\Cart::discount() > 0)
                <div class="summary-row discount"><span>{{ __('messages.discount') }} ({{ \App\Support\Cart::coupon()->code }})</span><b>- @price(\App\Support\Cart::discount()) {{ \App\Support\Fmt::toman() }}</b></div>
            @endif
            <div class="summary-row"><span>{{ __('messages.shipping') }}</span><b>{{ \App\Support\Cart::shipping() === 0 ? __('messages.shipping_free') : \App\Support\Fmt::price(\App\Support\Cart::shipping()) . ' ' . \App\Support\Fmt::toman() }}</b></div>
            <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price(\App\Support\Cart::total()) {{ \App\Support\Fmt::toman() }}</span></div>
        </div>
    </div>
</div>
@endsection
