@extends('layouts.app')

@section('title', __('messages.order_no') . ' ' . $order->code)

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>🧾 {{ __('messages.order_no') }} {{ $order->code }}</h1><p>{{ \App\Support\Fmt::date($order->created_at) }}</p></div>

    <div class="admin-detail-grid">
        <div class="table-wrap reveal">
            <h3 style="margin-bottom:14px">{{ __('messages.o_items') }}</h3>
            @foreach($order->items as $it)
                <div class="mc-item" style="margin-bottom:10px">
                    <img src="{{ asset($it->image) }}" alt="" style="width:56px;height:56px">
                    <div style="flex:1"><b>{{ $it->name }}</b><span>@num($it->qty) × @price($it->price)</span></div>
                    <b>@price($it->price * $it->qty)</b>
                </div>
            @endforeach
            @if($order->discount)
                <div class="summary-row discount"><span>{{ __('messages.discount') }}@if($order->coupon_code) ({{ $order->coupon_code }})@endif</span><b>- @price($order->discount)</b></div>
            @endif
            <div class="summary-row"><span>{{ __('messages.shipping') }}</span><b>{{ $order->shipping ? \App\Support\Fmt::price($order->shipping) : __('messages.shipping_free') }}</b></div>
            <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price($order->total) {{ \App\Support\Fmt::toman() }}</span></div>

            @if($order->status === 'pending' && $order->pay_method === 'online')
                <a class="btn btn-green" style="margin-top:16px;width:100%;justify-content:center" href="{{ route('payment.show', $order->code) }}">{{ __('messages.pay_retry') }}</a>
            @endif
        </div>

        <div>
            <div class="table-wrap reveal" style="margin-bottom:16px">
                <h3 style="margin-bottom:16px">{{ __('messages.track_status') }}</h3>
                @php($steps = ['pending', 'paid', 'shipped', 'delivered'])
                @php($reached = in_array($order->status, ['cancelled']) ? -1 : array_search($order->status, $steps))
                <div class="track-steps">
                    @foreach($steps as $i => $step)
                        <div class="t-step {{ $reached !== false && $i <= $reached ? 'done' : '' }}">
                            <div class="t-dot">{{ $reached !== false && $i <= $reached ? '✓' : $i + 1 }}</div>
                            <div>
                                <b>{{ __('messages.st_' . $step) }}</b>
                                <span>{{ __('messages.track_step_' . $step) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($order->status === 'cancelled')
                    <p style="color:#c0392b;margin-top:10px">✕ {{ __('messages.st_cancelled') }}</p>
                @endif
            </div>

            <div class="table-wrap reveal">
                <h3 style="margin-bottom:12px">{{ __('messages.tr_payment') }}</h3>
                <div class="summary-row"><span>{{ __('messages.pay_title') }}</span><b>{{ __('messages.pay_' . $order->pay_method) }}</b></div>
                @if($order->ref_id)<div class="summary-row"><span>{{ __('messages.tr_ref') }}</span><b dir="ltr">{{ $order->ref_id }}</b></div>@endif
            </div>
        </div>
    </div>

    <a class="btn btn-outline" style="margin-top:18px" href="{{ route('account') }}">← {{ __('messages.my_account') }}</a>
</div>
@endsection
