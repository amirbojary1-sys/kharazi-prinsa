@extends('layouts.app')

@section('title', '۴۰۴ — ' . __('messages.brand'))

@section('meta_desc'){{ __('messages.meta_default_desc') }}@endsection
@php($robots = 'noindex, follow')

@section('content')
<div class="container">
    <div class="empty-state reveal" style="padding:90px 20px">
        <div class="ic" style="font-size:3.4rem">🧭</div>
        <h1 style="font-size:2.6rem;letter-spacing:-1px">۴۰۴</h1>
        <h3>{{ __('messages.err404_title') }}</h3>
        <p style="color:var(--muted);max-width:440px;margin:8px auto 0">{{ __('messages.err404_sub') }}</p>
        <div style="margin-top:26px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a class="btn btn-green" href="{{ route('home') }}">{{ __('messages.back_home') }}</a>
            <a class="btn btn-primary" href="{{ route('shop') }}">{{ __('messages.cart_empty_cta') }}</a>
            <a class="btn btn-outline" href="{{ route('categories') }}">{{ __('messages.nav_categories') }}</a>
        </div>
    </div>
</div>
@endsection
