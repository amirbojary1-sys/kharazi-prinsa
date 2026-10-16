@extends('layouts.app')

@section('title', __('messages.admin_title'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>{{ __('messages.admin_title') }}</h1></div>
    @include('partials.admin-nav')

    <div class="stat-grid">
        <div class="stat-card reveal"><div class="ic">📦</div><div><b>@num($stats['products'])</b><span>{{ __('messages.stat_products') }}</span></div></div>
        <div class="stat-card reveal" data-delay="1"><div class="ic">🧾</div><div><b>@num($stats['orders'])</b><span>{{ __('messages.stat_orders') }}</span></div></div>
        <div class="stat-card reveal" data-delay="2"><div class="ic">💰</div><div><b>@price($stats['revenue'])</b><span>{{ __('messages.stat_revenue') }}</span></div></div>
        <div class="stat-card reveal" data-delay="3"><div class="ic">👥</div><div><b>@num($stats['customers'])</b><span>{{ __('messages.stat_customers') }}</span></div></div>
        <div class="stat-card reveal" data-delay="1"><div class="ic">📅</div><div><b>@price($stats['today'])</b><span>{{ __('messages.stat_today') }}</span></div></div>
        <div class="stat-card reveal" data-delay="2"><div class="ic">⏳</div><div><b>@num($stats['pending'])</b><span>{{ __('messages.stat_pending') }}</span></div></div>
        <div class="stat-card reveal" data-delay="3"><div class="ic">✅</div><div><b>@num($stats['paid'])</b><span>{{ __('messages.stat_paid') }}</span></div></div>
        <div class="stat-card reveal"><div class="ic">⚠️</div><div><b>@num($stats['low_stock'])</b><span>{{ __('messages.stat_low_stock') }}</span></div></div>
    </div>

    <div class="admin-detail-grid" style="margin-top:20px">
        <div class="table-wrap reveal">
            <h3 style="margin-bottom:18px">📈 {{ __('messages.chart_title') }}</h3>
            <div class="sales-chart">
                @foreach($chart as $bar)
                    <div class="sc-col" title="{{ $bar['label'] }} — {{ \App\Support\Fmt::price($bar['value']) }}">
                        <div class="sc-bar" style="height: {{ max(4, round($bar['value'] / $chartMax * 100)) }}%"></div>
                        <span>{{ $bar['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="table-wrap reveal">
            <h3 style="margin-bottom:14px">🏆 {{ __('messages.top_products') }}</h3>
            @forelse($topProducts as $tp)
                <div class="mc-item" style="margin-bottom:10px">
                    <img src="{{ asset($tp->image) }}" alt="" style="width:46px;height:46px">
                    <div style="flex:1">
                        <b>{{ app()->getLocale() === 'fa' ? $tp->name_fa : $tp->name_en }}</b>
                        <span>{{ __('messages.top_sold') }}: @num($tp->sold)</span>
                    </div>
                    <b>@price($tp->revenue)</b>
                </div>
            @empty
                <p style="color:var(--muted);padding:20px 0">{{ __('messages.no_orders') }}</p>
            @endforelse
        </div>
    </div>

    <div class="table-wrap reveal" style="margin-top:20px">
        <h3 style="margin-bottom:14px">🧾 {{ __('messages.admin_orders') }}</h3>
        <table>
            <thead>
            <tr>
                <th>{{ __('messages.order_no') }}</th>
                <th>{{ __('messages.o_customer') }}</th>
                <th>{{ __('messages.o_items') }}</th>
                <th>{{ __('messages.grand_total') }}</th>
                <th>{{ __('messages.o_status') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $o)
                <tr>
                    <td><b>{{ $o->code }}</b></td>
                    <td>{{ $o->customer_name }}</td>
                    <td>@num($o->items->sum('qty'))</td>
                    <td><b>@price($o->total)</b></td>
                    <td><span class="tag {{ $o->status }}">{{ __('messages.st_' . $o->status) }}</span></td>
                    <td><a class="mini-btn" href="{{ route('admin.orders.show', $o->id) }}">{{ __('messages.admin_view') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:36px;color:var(--muted)">{{ __('messages.no_orders') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
