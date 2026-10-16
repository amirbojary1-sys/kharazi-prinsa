@extends('layouts.app')

@section('title', __('messages.cat_title'))

@section('meta_desc'){{ __('messages.meta_categories_desc') }}@endsection
@php($robots = 'index, follow')

@section('content')
    <div class="container">
        <div class="page-head reveal">
            <div class="crumbs"><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a> / {{ __('messages.cat_title') }}</div>
            <h1 class="grad-title">{{ __('messages.cat_title') }}</h1>
            <p style="color:var(--muted)">{{ __('messages.cat_sub') }}</p>
        </div>

        {{-- editorial mosaic of all categories --}}
        <div class="cat-mosaic">
            @foreach($categories as $i => $c)
                <a class="cat-card lux cat-mosaic-item {{ $i < 2 ? 'big' : '' }} reveal" data-delay="{{ $i % 4 }}"
                   href="{{ route('category', $c->slug) }}">
                    <span class="cat-count">@num($c->products_count) {{ __('messages.items') }}</span>
                    <img src="{{ asset($c->image) }}" alt="{{ $c->name }}" loading="lazy">
                    <div class="overlay">
                        <h3>{{ $c->name }}</h3>
                        <p>{{ $c->desc }}</p>
                        <div class="cat-subs">
                            @foreach($c->subcategories as $s)
                                <span onclick="event.preventDefault();location.href='{{ route('category', ['slug' => $c->slug, 'sub' => $s->slug]) }}'">{{ $s->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
