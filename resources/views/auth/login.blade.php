@extends('layouts.app')

@section('title', __('messages.login'))

@section('content')
<div class="auth-wrap">
    {{-- ===== cinematic visual side ===== --}}
    <div class="auth-visual">
        <div class="bg" style="background-image:url('{{ asset('images/banner-atelier.jpg') }}')"></div>
        <div class="veil"></div>
        <div class="frame"></div>
        <div class="content">
            <div class="hero-kicker">👑 {{ __('messages.brand') }}</div>
            <h2>{{ __('messages.auth_welcome') }} <em>✨</em></h2>
            <p>{{ __('messages.auth_welcome_d') }}</p>
            <div class="trust">
                <span>🚚 {{ __('messages.strip1_t') }}</span>
                <span>💎 {{ __('messages.strip2_t') }}</span>
                <span>🔒 {{ __('messages.auth_secure') }}</span>
            </div>
        </div>
    </div>

    {{-- ===== form side ===== --}}
    <div class="auth-panel">
        <div class="auth-card">
            <div class="logo-mark">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z" fill="#C7F0D8"/></svg>
            </div>
            <h1>{{ __('messages.auth_welcome') }}</h1>
            <p class="sub">{{ __('messages.auth_welcome_d') }}</p>

            <form method="POST" action="{{ route('login.submit') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label>{{ __('messages.admin_email') }}</label>
                    <input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label>{{ __('messages.password') }}</label>
                    <input class="input" type="password" name="password" required>
                </div>
                <label class="auth-check">
                    <input type="checkbox" name="remember">
                    {{ __('messages.my_account') }} — Remember me
                </label>
                <button class="btn btn-primary btn-sweep btn-block" type="submit">{{ __('messages.login') }} ←</button>
            </form>

            <div class="auth-divider">✦</div>

            <div class="auth-alt">
                {{ __('messages.auth_no_acc') }}
                <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
            </div>

            <div class="auth-secure">
                <div class="lock">🔒</div>
                {{ __('messages.auth_secure') }}
            </div>
        </div>
    </div>
</div>
@endsection
