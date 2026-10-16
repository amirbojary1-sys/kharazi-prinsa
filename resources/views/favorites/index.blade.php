@extends('layouts.app')

@section('title', __('messages.fav_title'))

@section('meta_desc'){{ __('messages.meta_default_desc') }}@endsection
@php($robots = 'noindex, nofollow')

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>♥ {{ __('messages.fav_title') }}</h1><p>{{ __('messages.fav_sub') }}</p></div>

    @if($products->count())
        <div class="product-grid">
            @foreach($products as $p)
                @include('partials.product-card', ['p' => $p])
            @endforeach
        </div>
        <div style="margin-top:28px">
            <a class="btn btn-outline" href="{{ route('shop') }}">← {{ __('messages.continue') }}</a>
        </div>
    @else
        <div class="empty-state reveal">
            <div class="ic">🤍</div>
            <h3>{{ __('messages.fav_empty') }}</h3>
            <a class="btn btn-green" href="{{ route('shop') }}">{{ __('messages.fav_empty_cta') }}</a>
        </div>
    @endif
</div>
@endsection
