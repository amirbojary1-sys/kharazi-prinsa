@extends('layouts.app')

@section('title', __('messages.order_no') . ' ' . $order->code)

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>🧾 {{ __('messages.order_no') }} {{ $order->code }}</h1></div>
    @include('partials.admin-nav')

    <div class="admin-detail-grid">
        <div class="table-wrap reveal">
            <h3 style="margin-bottom:14px">{{ __('messages.o_items') }}</h3>
            @foreach($order->items as $it)
                <div class="mc-item" style="margin-bottom:10px">
                    <img src="{{ asset($it->image) }}" alt="" style="width:56px;height:56px">
                    <div style="flex:1">
                        <b>{{ $it->name }}</b>
                        <span>@num($it->qty) × @price($it->price)</span>
                    </div>
                    <b>@price($it->price * $it->qty)</b>
                </div>
            @endforeach
            <div class="summary-row"><span>{{ __('messages.subtotal') }}</span><b>@price($order->discount ? $order->subtotal - $order->discount : $order->subtotal)</b></div>
            @if($order->discount)
                <div class="summary-row" style="color:#c0392b"><span>{{ __('messages.discount') }} @if($order->coupon_code)({{ $order->coupon_code }})@endif</span><b>- @price($order->discount)</b></div>
            @endif
            <div class="summary-row"><span>{{ __('messages.shipping') }}</span><b>{{ $order->shipping ? \App\Support\Fmt::price($order->shipping) . ' ' . \App\Support\Fmt::toman() : __('messages.shipping_free') }}</b></div>
            <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price($order->total) {{ \App\Support\Fmt::toman() }}</span></div>
        </div>

        <div>
            <div class="table-wrap reveal" style="margin-bottom:18px">
                <h3 style="margin-bottom:14px">{{ __('messages.o_customer') }}</h3>
                <div class="summary-row"><span>{{ __('messages.checkout_name') }}</span><b>{{ $order->customer_name }}</b></div>
                <div class="summary-row"><span>{{ __('messages.checkout_phone') }}</span><b dir="ltr">{{ $order->phone }}</b></div>
                @if($order->email)<div class="summary-row"><span>{{ __('messages.checkout_email') }}</span><b>{{ $order->email }}</b></div>@endif
                <div class="summary-row"><span>{{ __('messages.checkout_city') }}</span><b>{{ $order->city }}</b></div>
                <div class="summary-row"><span>{{ __('messages.checkout_address') }}</span><b>{{ $order->address }}</b></div>
                @if($order->notes)<div class="summary-row"><span>{{ __('messages.checkout_notes') }}</span><b>{{ $order->notes }}</b></div>@endif
            </div>

            <div class="table-wrap reveal">
                <h3 style="margin-bottom:14px">{{ __('messages.tr_payment') }}</h3>
                <div class="summary-row"><span>{{ __('messages.pay_title') }}</span><b>{{ __('messages.pay_' . $order->pay_method) }}</b></div>
                @if($order->ref_id)<div class="summary-row"><span>{{ __('messages.tr_ref') }}</span><b dir="ltr">{{ $order->ref_id }}</b></div>@endif
                @if($order->card_pan)<div class="summary-row"><span>{{ __('messages.tr_card') }}</span><b dir="ltr">{{ $order->card_pan }}</b></div>@endif
                @if($order->paid_at)<div class="summary-row"><span>{{ __('messages.tr_date') }}</span><b>{{ \App\Support\Fmt::date($order->paid_at) }}</b></div>@endif
                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}" style="margin-top:16px;display:flex;gap:10px">
                    @csrf
                    <select name="status" class="form-input" style="flex:1">
                        @foreach(['pending','paid','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ __('messages.st_' . $s) }}</option>
                        @endforeach
                    </select>
                    <button class="mini-btn">{{ __('messages.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
