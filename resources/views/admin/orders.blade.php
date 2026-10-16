@extends('layouts.app')

@section('title', __('messages.admin_orders'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>{{ __('messages.admin_orders') }}</h1></div>

    @include('partials.admin-nav')

    <div class="admin-topbar" style="margin:14px 0">
        <form method="GET" action="{{ route('admin.orders') }}" style="display:flex;gap:8px;flex:1;max-width:520px">
            <input class="form-input" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.admin_order_search') }}">
            <select class="form-input" name="status" style="max-width:180px">
                <option value="">{{ __('messages.all') }}</option>
                @foreach(['pending','paid','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ __('messages.st_' . $s) }}</option>
                @endforeach
            </select>
            <button class="mini-btn">{{ __('messages.search_btn') }}</button>
        </form>
        <h2>🧾 (@num($orders->count()))</h2>
    </div>

    <div class="table-wrap reveal">
        <table>
            <thead>
            <tr>
                <th>{{ __('messages.order_no') }}</th>
                <th>{{ __('messages.o_date') }}</th>
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
                    <td>@fdate($o->created_at)</td>
                    <td>{{ $o->customer_name }}<br><span style="color:var(--muted);font-size:.78rem">{{ $o->phone }}</span></td>
                    <td>@num($o->items->sum('qty'))</td>
                    <td><b>@price($o->total)</b></td>
                    <td>
                        <form method="POST" action="{{ route('admin.orders.status', $o->id) }}">
                            @csrf
                            <select class="select-box" name="status" data-autosubmit style="height:38px;font-size:.8rem">
                                @foreach(['pending','paid','shipped','delivered','cancelled'] as $s)
                                    <option value="{{ $s }}" @selected($o->status === $s)>{{ __('messages.st_' . $s) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:36px;color:var(--muted)">{{ __('messages.no_orders') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
