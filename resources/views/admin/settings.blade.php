@extends('layouts.app')

@section('title', __('messages.admin_settings'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>⚙️ {{ __('messages.admin_settings') }}</h1></div>
    @include('partials.admin-nav')

    <form method="POST" action="{{ route('admin.settings.save') }}" class="form-card reveal" style="margin:18px 0;max-width:760px">
        @csrf
        <h3 style="margin-bottom:14px">🏪 {{ __('messages.set_store') }}</h3>
        <div class="form-group"><label>{{ __('messages.set_store_name') }}</label>
            <input class="form-input" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required></div>
        <div class="form-row">
            <div class="form-group"><label>{{ __('messages.set_store_phone') }}</label>
                <input class="form-input" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}"></div>
            <div class="form-group"><label>{{ __('messages.set_store_address') }}</label>
                <input class="form-input" name="store_address" value="{{ old('store_address', $settings['store_address']) }}"></div>
        </div>

        <h3 style="margin:22px 0 14px">🚚 {{ __('messages.set_shipping') }}</h3>
        <div class="form-row">
            <div class="form-group"><label>{{ __('messages.set_ship_cost') }}</label>
                <input class="form-input" type="number" name="shipping_cost" value="{{ old('shipping_cost', $settings['shipping_cost']) }}" required></div>
            <div class="form-group"><label>{{ __('messages.set_ship_free') }}</label>
                <input class="form-input" type="number" name="free_ship_min" value="{{ old('free_ship_min', $settings['free_ship_min']) }}" required></div>
        </div>

        <h3 style="margin:22px 0 14px">💳 {{ __('messages.set_gateway') }}</h3>
        <div class="form-row">
            <div class="form-group"><label>{{ __('messages.set_gw_mode') }}</label>
                <select class="form-input" name="gateway_mode">
                    <option value="demo" @selected($settings['gateway_mode'] === 'demo')>{{ __('messages.set_gw_demo') }}</option>
                    <option value="zarinpal" @selected($settings['gateway_mode'] === 'zarinpal')>ZarinPal</option>
                </select></div>
            <div class="form-group"><label>{{ __('messages.set_gw_merchant') }}</label>
                <input class="form-input" name="gateway_merchant" dir="ltr" value="{{ old('gateway_merchant', $settings['gateway_merchant']) }}" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"></div>
        </div>
        <p style="font-size:.8rem;color:var(--muted);margin:6px 0 18px">{{ __('messages.set_gw_hint') }}</p>

        <button class="btn btn-green">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection
