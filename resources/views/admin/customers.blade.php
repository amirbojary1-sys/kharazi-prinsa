@extends('layouts.app')

@section('title', __('messages.admin_customers'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>👥 {{ __('messages.admin_customers') }}</h1></div>
    @include('partials.admin-nav')

    <h3 style="margin:18px 0 10px">{{ __('messages.cust_registered') }}</h3>
    <div class="table-wrap reveal">
        <table>
            <thead><tr>
                <th>{{ __('messages.checkout_name') }}</th><th>{{ __('messages.checkout_email') }}</th><th>{{ __('messages.checkout_phone') }}</th>
                <th>{{ __('messages.stat_orders') }}</th><th>{{ __('messages.stat_revenue') }}</th><th></th>
            </tr></thead>
            <tbody>
            @forelse($users as $u)
                <tr>
                    <td><b>{{ $u->name }}</b></td>
                    <td dir="ltr">{{ $u->email }}</td>
                    <td dir="ltr">{{ $u->phone ?: '—' }}</td>
                    <td>@num($u->orders_count)</td>
                    <td>@price($u->orders_sum_total ?? 0)</td>
                    <td><a class="mini-btn" href="{{ route('admin.customers.show', $u->id) }}">{{ __('messages.admin_view') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_customers') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <h3 style="margin:26px 0 10px">{{ __('messages.cust_guests') }}</h3>
    <div class="table-wrap reveal">
        <table>
            <thead><tr>
                <th>{{ __('messages.checkout_name') }}</th><th>{{ __('messages.checkout_phone') }}</th>
                <th>{{ __('messages.stat_orders') }}</th><th>{{ __('messages.stat_revenue') }}</th><th>{{ __('messages.tr_date') }}</th>
            </tr></thead>
            <tbody>
            @forelse($guests as $g)
                <tr>
                    <td><b>{{ $g->customer_name }}</b></td>
                    <td dir="ltr">{{ $g->phone }}</td>
                    <td>@num($g->orders_count)</td>
                    <td>@price($g->total_sum)</td>
                    <td>{{ \App\Support\Fmt::date($g->last_order) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_customers') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
