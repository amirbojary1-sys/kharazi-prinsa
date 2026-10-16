@extends('layouts.app')

@section('title', __('messages.about_title'))

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>{{ __('messages.about_title') }}</h1></div>
    <div class="about-layout">
        <img class="reveal" src="{{ asset('images/hero.jpg') }}" alt="{{ __('messages.about_title') }}">
        <div class="about-text reveal" data-delay="1">
            <h2>{{ __('messages.brand') }} ✨</h2>
            <p>{{ __('messages.about_p1') }}</p>
            <p>{{ __('messages.about_p2') }}</p>
            <div class="stat-row">
                <div class="stat"><b>+@num(\App\Models\Product::count())</b><span>{{ __('messages.stat_products') }}</span></div>
                <div class="stat"><b>+@num(1500)</b><span>{{ __('messages.stat_customers') }}</span></div>
                <div class="stat"><b>@num(\App\Models\Category::count())</b><span>{{ __('messages.filter_cats') }}</span></div>
            </div>
            <div style="margin-top:28px;display:flex;gap:12px;flex-wrap:wrap">
                <a class="btn btn-green" href="{{ route('shop') }}">{{ __('messages.hero_cta') }}</a>
                <a class="btn btn-outline" href="{{ route('contact') }}">{{ __('messages.nav_contact') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
