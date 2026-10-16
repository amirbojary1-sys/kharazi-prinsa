@extends('layouts.app')

@section('title', __('messages.admin_title'))

@section('content')
<div class="container admin-shell">
    <div class="admin-login form-card reveal">
        <div style="text-align:center;margin-bottom:22px">
            <div class="logo-mark" style="margin-inline:auto;width:64px;height:64px;border-radius:20px">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z" fill="#C7F0D8"/></svg>
            </div>
            <h2 style="color:var(--green-800);margin-top:14px">{{ __('messages.admin_title') }}</h2>
            <p style="color:var(--muted);font-size:.85rem">{{ __('messages.admin_hint') }}</p>
        </div>
        <form method="POST" action="{{ route('admin.login.submit') }}" style="display:flex;flex-direction:column;gap:15px">
            @csrf
            <div class="form-group"><label>{{ __('messages.admin_email') }}</label><input class="input" name="email" type="email" required></div>
            <div class="form-group"><label>{{ __('messages.admin_pass') }}</label><input class="input" name="password" type="password" required></div>
            <button class="btn btn-green btn-block" type="submit">{{ __('messages.admin_login') }}</button>
        </form>
    </div>
</div>
@endsection
