@extends('layouts.app')

@section('title', __('messages.register'))

@section('meta_desc'){{ __('messages.meta_default_desc') }}@endsection
@php($robots = 'noindex, follow')

@section('content')
<div class="auth-wrap">
    {{-- ===== cinematic visual side ===== --}}
    <div class="auth-visual">
        <div class="bg" style="background-image:url('{{ asset('images/hero-cinematic.jpg') }}')"></div>
        <div class="veil"></div>
        <div class="frame"></div>
        <div class="content">
            <div class="hero-kicker">✨ {{ __('messages.hero_kicker') }}</div>
            <h2>{{ __('messages.auth_create') }} <em>👑</em></h2>
            <p>{{ __('messages.auth_create_d') }}</p>
            <div class="trust">
                <span>🎀 {{ __('messages.strip4_t') }}</span>
                <span>💬 {{ __('messages.strip3_t') }}</span>
                <span>📦 {{ __('messages.feat_sub') }}</span>
            </div>
        </div>
    </div>

    {{-- ===== form side ===== --}}
    <div class="auth-panel">
        <div class="auth-card">
            <div class="logo-mark">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z" fill="#C7F0D8"/></svg>
            </div>
            <h1>{{ __('messages.auth_create') }}</h1>
            <p class="sub">{{ __('messages.auth_create_d') }}</p>

            @if($errors->any())
                <div class="auth-err">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="auth-form">
                @csrf
                <div class="form-group">
                    <label>{{ __('messages.f_name') }}</label>
                    <input class="input" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>{{ __('messages.admin_email') }}</label>
                        <input class="input" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.auth_phone') }}</label>
                        <input class="input" name="phone" value="{{ old('phone') }}" inputmode="tel">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label>{{ __('messages.password') }}</label>
                        <input class="input" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.confirm_password') }}</label>
                        <input class="input" type="password" name="password_confirmation" required>
                    </div>
                </div>
                <button class="btn btn-primary btn-sweep btn-block" type="submit">{{ __('messages.register') }} ←</button>
            </form>

            <div class="auth-divider">✦</div>

            <div class="auth-alt">
                {{ __('messages.auth_have_acc') }}
                <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
            </div>

            <div class="auth-secure">
                <div class="lock">🔒</div>
                {{ __('messages.auth_secure') }}
            </div>
        </div>
    </div>
</div>
@endsection
