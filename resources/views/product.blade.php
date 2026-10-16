@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="page-head reveal">
        <div class="crumbs">
            <a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a> /
            <a href="{{ route('shop') }}">{{ __('messages.shop_title') }}</a> /
            {{ $product->name }}
        </div>
    </div>

    <div class="pd-layout">
        <div class="pd-media reveal">
            @if($product->featured)<span class="badge gold">⭐</span>@endif
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        </div>
        <div class="pd-info reveal" data-delay="1">
            <span class="pd-cat">{{ $product->category->name }}{{ $product->subcategory ? ' · ' . $product->subcategory->name : '' }}</span>
            <h1>{{ $product->name }}</h1>
            <div class="pd-price">@price($product->price) <small>{{ \App\Support\Fmt::toman() }}</small></div>
            <p class="pd-desc">{{ $product->desc }}</p>
            <div class="pd-stock {{ $product->stock <= 0 ? 'out' : '' }}">
                {{ $product->stock <= 0 ? '✕ ' . __('messages.out_stock') : '✓ ' . __('messages.stock_left') . ' (' . \App\Support\Fmt::num($product->stock) . ')' }}
            </div>

            <form method="POST" action="{{ route('favorites.toggle', $product->id) }}" id="favForm" style="display:none">@csrf</form>
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="pd-actions">
                @csrf
                <div class="qty-control">
                    <button type="button" data-action="qty" data-d="-1">−</button>
                    <input name="qty" value="1" inputmode="numeric">
                    <button type="button" data-action="qty" data-d="1">+</button>
                </div>
                <button class="btn btn-green" type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}>🛒 {{ __('messages.add_cart') }}</button>
                <button class="btn btn-primary" type="submit" name="buy" value="1" {{ $product->stock <= 0 ? 'disabled' : '' }}>{{ __('messages.buy_now') }}</button>
                <button type="submit" form="favForm" class="btn btn-outline pd-fav {{ \App\Support\Favs::has($product->id) ? 'on' : '' }}" title="{{ __('messages.fav_title') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ \App\Support\Favs::has($product->id) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                    {{ __('messages.fav_add') }}
                </button>
            </form>

            <ul class="pd-features">
                <li><span class="tick">✓</span>{{ __('messages.strip2_t') }} — {{ __('messages.strip2_d') }}</li>
                <li><span class="tick">✓</span>{{ __('messages.strip1_t') }} — {{ __('messages.strip1_d') }}</li>
                <li><span class="tick">✓</span>{{ __('messages.strip3_t') }} — {{ __('messages.strip3_d') }}</li>
            </ul>
        </div>
    </div>

    @if($related->count())
        <section class="section" style="padding-top:0">
            <div class="section-head reveal"><h2>{{ __('messages.related') }}</h2></div>
            <div class="product-grid">
                @foreach($related as $p)
                    @include('partials.product-card', ['p' => $p])
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
