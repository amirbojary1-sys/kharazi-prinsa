@extends('layouts.app')

@section('title', $customer->name)

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>👤 {{ $customer->name }}</h1></div>
    @include('partials.admin-nav')

    <div class="stat-grid" style="margin:18px 0">
        <div class="stat-card reveal"><div class="ic">✉️</div><div><b style="font-size:.95rem">{{ $customer->email }}</b><span>{{ __('messages.checkout_email') }}</span></div></div>
        <div class="stat-card reveal" data-delay="1"><div class="ic">📞</div><div><b>{{ $customer->phone ?: '—' }}</b><span>{{ __('messages.checkout_phone') }}</span></div></div>
        <div class="stat-card reveal" data-delay="2"><div class="ic">🧾</div><div><b>@num($orders->count())</b><span>{{ __('messages.stat_orders') }}</span></div></div>
        <div class="stat-card reveal" data-delay="3"><div class="ic">💰</div><div><b>@price($orders->sum('total'))</b><span>{{ __('messages.stat_revenue') }}</span></div></div>
    </div>

    <div class="table-wrap reveal">
        <table>
            <thead><tr>
                <th>{{ __('messages.order_no') }}</th><th>{{ __('messages.o_items') }}</th><th>{{ __('messages.grand_total') }}</th>
                <th>{{ __('messages.tr_payment') }}</th><th>{{ __('messages.o_status') }}</th><th></th>
            </tr></thead>
            <tbody>
            @forelse($orders as $o)
                <tr>
                    <td><b>{{ $o->code }}</b></td>
                    <td>@num($o->items->sum('qty'))</td>
                    <td><b>@price($o->total)</b></td>
                    <td>{{ __('messages.pay_' . $o->pay_method) }}</td>
                    <td><span class="tag {{ $o->status }}">{{ __('messages.st_' . $o->status) }}</span></td>
                    <td><a class="mini-btn" href="{{ route('admin.orders.show', $o->id) }}">{{ __('messages.admin_view') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_orders') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
