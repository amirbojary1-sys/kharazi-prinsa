@extends('layouts.app')

@section('title', __('messages.admin_transactions'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>💳 {{ __('messages.admin_transactions') }}</h1></div>
    @include('partials.admin-nav')

    <div class="table-wrap reveal" style="margin-top:18px">
        <table>
            <thead><tr>
                <th>{{ __('messages.order_no') }}</th><th>{{ __('messages.o_customer') }}</th><th>{{ __('messages.grand_total') }}</th>
                <th>{{ __('messages.tr_ref') }}</th><th>{{ __('messages.tr_card') }}</th><th>{{ __('messages.tr_date') }}</th><th>{{ __('messages.o_status') }}</th><th></th>
            </tr></thead>
            <tbody>
            @forelse($orders as $o)
                <tr>
                    <td><b>{{ $o->code }}</b></td>
                    <td>{{ $o->customer_name }}</td>
                    <td><b>@price($o->total)</b></td>
                    <td dir="ltr">{{ $o->ref_id ?: '—' }}</td>
                    <td dir="ltr">{{ $o->card_pan ?: '—' }}</td>
                    <td>{{ $o->paid_at ? \App\Support\Fmt::date($o->paid_at) : '—' }}</td>
                    <td><span class="tag {{ $o->status }}">{{ __('messages.st_' . $o->status) }}</span></td>
                    <td><a class="mini-btn" href="{{ route('admin.orders.show', $o->id) }}">{{ __('messages.admin_view') }}</a></td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_transactions') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
