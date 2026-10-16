@extends('layouts.app')

@section('title', __('messages.track_title'))

@section('meta_desc'){{ __('messages.meta_track_desc') }}@endsection
@php($robots = 'index, follow')

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>🔎 {{ __('messages.track_title') }}</h1><p>{{ __('messages.track_sub') }}</p></div>

    <form method="POST" action="{{ route('track.lookup') }}" class="form-card reveal" style="max-width:520px;margin-inline:auto">
        @csrf
        <div class="form-group"><label>{{ __('messages.order_no') }}</label>
            <input class="form-input" name="code" value="{{ old('code') }}" placeholder="PR-1001" dir="ltr" required></div>
        <div class="form-group"><label>{{ __('messages.checkout_phone') }}</label>
            <input class="form-input" name="phone" value="{{ old('phone') }}" dir="ltr" required></div>
        <button class="btn btn-green" style="width:100%;justify-content:center">{{ __('messages.track_btn') }}</button>
    </form>

    @isset($order)
        <div class="admin-detail-grid" style="margin-top:24px">
            <div class="table-wrap reveal">
                <h3 style="margin-bottom:14px">{{ __('messages.order_no') }} {{ $order->code }} — <span class="tag {{ $order->status }}">{{ __('messages.st_' . $order->status) }}</span></h3>
                @foreach($order->items as $it)
                    <div class="mc-item" style="margin-bottom:10px">
                        <img src="{{ asset($it->image) }}" alt="" style="width:52px;height:52px">
                        <div style="flex:1"><b>{{ $it->name }}</b><span>@num($it->qty) × @price($it->price)</span></div>
                        <b>@price($it->price * $it->qty)</b>
                    </div>
                @endforeach
                <div class="summary-total"><span>{{ __('messages.grand_total') }}</span><span>@price($order->total) {{ \App\Support\Fmt::toman() }}</span></div>
            </div>
            <div class="table-wrap reveal">
                <h3 style="margin-bottom:16px">{{ __('messages.track_status') }}</h3>
                @php($steps = ['pending', 'paid', 'shipped', 'delivered'])
                @php($reached = $order->status === 'cancelled' ? -1 : array_search($order->status, $steps))
                <div class="track-steps">
                    @foreach($steps as $i => $step)
                        <div class="t-step {{ $reached !== false && $i <= $reached ? 'done' : '' }}">
                            <div class="t-dot">{{ $reached !== false && $i <= $reached ? '✓' : $i + 1 }}</div>
                            <div><b>{{ __('messages.st_' . $step) }}</b><span>{{ __('messages.track_step_' . $step) }}</span></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset
</div>
@endsection
