@extends('layouts.app')

@section('title', __('messages.admin_coupons'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>🏷️ {{ __('messages.admin_coupons') }}</h1></div>
    @include('partials.admin-nav')

    <form method="POST" action="{{ route('admin.coupons.store') }}" class="form-card reveal" style="margin:18px 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;align-items:end">
        @csrf
        <div class="form-group"><label>{{ __('messages.coupon_code') }}</label>
            <input class="form-input" name="code" required placeholder="PRINSA10" style="direction:ltr"></div>
        <div class="form-group"><label>{{ __('messages.coupon_type') }}</label>
            <select class="form-input" name="type">
                <option value="percent">{{ __('messages.coupon_percent') }}</option>
                <option value="fixed">{{ __('messages.coupon_fixed') }}</option>
            </select></div>
        <div class="form-group"><label>{{ __('messages.coupon_value') }}</label>
            <input class="form-input" name="value" type="number" min="1" required></div>
        <div class="form-group"><label>{{ __('messages.coupon_min_amount') }}</label>
            <input class="form-input" name="min_amount" type="number" min="0" value="0"></div>
        <div class="form-group"><label>{{ __('messages.coupon_max_uses') }}</label>
            <input class="form-input" name="max_uses" type="number" min="1"></div>
        <div class="form-group"><label>{{ __('messages.coupon_expires') }}</label>
            <input class="form-input" name="expires_at" type="date"></div>
        <button class="btn btn-green" style="height:48px">{{ __('messages.save') }}</button>
    </form>

    <div class="table-wrap reveal">
        <table>
            <thead><tr>
                <th>{{ __('messages.coupon_code') }}</th><th>{{ __('messages.coupon_type') }}</th><th>{{ __('messages.coupon_value') }}</th>
                <th>{{ __('messages.coupon_min_amount') }}</th><th>{{ __('messages.coupon_uses') }}</th>
                <th>{{ __('messages.coupon_expires') }}</th><th>{{ __('messages.o_status') }}</th><th></th>
            </tr></thead>
            <tbody>
            @forelse($coupons as $c)
                <tr>
                    <td><b dir="ltr">{{ $c->code }}</b></td>
                    <td>{{ __('messages.coupon_' . ($c->type === 'percent' ? 'percent' : 'fixed')) }}</td>
                    <td>{{ $c->type === 'percent' ? \App\Support\Fmt::num($c->value) . '٪' : \App\Support\Fmt::price($c->value) . ' ' . \App\Support\Fmt::toman() }}</td>
                    <td>@price($c->min_amount)</td>
                    <td>{{ \App\Support\Fmt::num($c->used_count) }}{{ $c->max_uses ? ' / ' . \App\Support\Fmt::num($c->max_uses) : '' }}</td>
                    <td>{{ $c->expires_at ? \App\Support\Fmt::date($c->expires_at) : '—' }}</td>
                    <td><span class="tag {{ $c->active ? 'paid' : 'cancelled' }}">{{ $c->active ? __('messages.coupon_active') : __('messages.coupon_inactive') }}</span></td>
                    <td style="white-space:nowrap">
                        <form method="POST" action="{{ route('admin.coupons.toggle', $c->id) }}" style="display:inline">@csrf
                            <button class="mini-btn">{{ $c->active ? __('messages.coupon_disable') : __('messages.coupon_enable') }}</button></form>
                        <form method="POST" action="{{ route('admin.coupons.destroy', $c->id) }}" style="display:inline">@csrf @method('DELETE')
                            <button class="mini-btn danger">{{ __('messages.admin_delete') }}</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_coupons') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
