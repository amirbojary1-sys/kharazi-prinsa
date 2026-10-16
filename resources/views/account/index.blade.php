@extends('layouts.app')

@section('title', __('messages.my_account'))

@section('meta_desc'){{ __('messages.meta_default_desc') }}@endsection
@php($robots = 'noindex, nofollow')

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>👤 {{ __('messages.my_account') }}</h1><p>{{ \App\Support\Fmt::num($orders->count()) }} {{ __('messages.stat_orders') }}</p></div>

    <div class="admin-detail-grid">
        <div>
            <h3 style="margin:6px 0 12px">🧾 {{ __('messages.my_orders') }}</h3>
            <div class="table-wrap reveal">
                <table>
                    <thead><tr>
                        <th>{{ __('messages.order_no') }}</th><th>{{ __('messages.o_date') }}</th>
                        <th>{{ __('messages.grand_total') }}</th><th>{{ __('messages.o_status') }}</th><th></th>
                    </tr></thead>
                    <tbody>
                    @forelse($orders as $o)
                        <tr>
                            <td><b>{{ $o->code }}</b></td>
                            <td>{{ \App\Support\Fmt::date($o->created_at) }}</td>
                            <td><b>@price($o->total)</b></td>
                            <td><span class="tag {{ $o->status }}">{{ __('messages.st_' . $o->status) }}</span></td>
                            <td><a class="mini-btn" href="{{ route('account.order', $o->id) }}">{{ __('messages.admin_view') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_orders') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <a class="btn btn-outline" style="margin-top:14px" href="{{ route('track') }}">🔎 {{ __('messages.track_title') }}</a>
        </div>

        <div>
            <h3 style="margin:6px 0 12px">⚙️ {{ __('messages.profile_title') }}</h3>
            <form method="POST" action="{{ route('account.profile') }}" class="form-card reveal">
                @csrf
                <div class="form-group"><label>{{ __('messages.checkout_name') }}</label>
                    <input class="form-input" name="name" value="{{ old('name', $user->name) }}" required></div>
                <div class="form-group"><label>{{ __('messages.checkout_email') }}</label>
                    <input class="form-input" value="{{ $user->email }}" disabled dir="ltr"></div>
                <div class="form-group"><label>{{ __('messages.checkout_phone') }}</label>
                    <input class="form-input" name="phone" value="{{ old('phone', $user->phone) }}" dir="ltr"></div>

                <h4 style="margin:16px 0 8px">{{ __('messages.change_password') }}</h4>
                <div class="form-group"><label>{{ __('messages.current_password') }}</label>
                    <input class="form-input" type="password" name="password" dir="ltr"></div>
                <div class="form-group"><label>{{ __('messages.new_password') }}</label>
                    <input class="form-input" type="password" name="new_password" dir="ltr"></div>
                <div class="form-group"><label>{{ __('messages.confirm_password') }}</label>
                    <input class="form-input" type="password" name="new_password_confirmation" dir="ltr"></div>

                <button class="btn btn-green" style="margin-top:8px">{{ __('messages.save') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
