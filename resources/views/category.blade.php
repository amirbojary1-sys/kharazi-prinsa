@extends('layouts.app')

@section('title', $category->name)

@section('meta_desc')
{{ \Illuminate\Support\Str::limit(($category->desc ?? '') ?: __('messages.meta_shop_desc'), 155) }}
@endsection
@php($jsonLd = [
    \App\Support\SEO::breadcrumbSchema([
        ['name' => __('messages.nav_home'), 'url' => route('home')],
        ['name' => $category->name],
    ]),
])
@php($robots = 'index, follow')

@section('content')
    {{-- ===== photographic hero banner ===== --}}
    <section class="cat-hero">
        <div class="bg" style="background-image:url('{{ asset($category->image) }}')"></div>
        <div class="veil"></div>
        <div class="container cat-hero-content">
            <div class="crumbs" style="color:rgba(255,255,255,.75)">
                <a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a> /
                <a href="{{ route('categories') }}">{{ __('messages.cat_title') }}</a> /
                {{ $category->name }}
            </div>
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->desc }}</p>
            <div class="cat-hero-stats">
                <span>📦 @num($category->products_count) {{ __('messages.items') }}</span>
                <span>🗂 @num($category->subcategories->count()) {{ __('messages.filter_cats') }}</span>
            </div>
        </div>
    </section>

    <div class="container">
        {{-- ===== subcategory pills ===== --}}
        <div class="sub-pills" style="margin-top:32px">
            <a href="{{ route('category', $category->slug) }}" class="{{ $activeSub === 'all' ? 'active' : '' }}">{{ __('messages.all_cats') }}</a>
            @foreach($category->subcategories as $s)
                <a href="{{ route('category', ['slug' => $category->slug, 'sub' => $s->slug]) }}" class="{{ $activeSub === $s->slug ? 'active' : '' }}">
                    {{ $s->name }} · @num($s->products_count ?? $s->products()->count())
                </a>
            @endforeach
        </div>

        {{-- ===== products ===== --}}
        <div style="padding-block:10px 60px">
            @if($products->count())
                <div class="product-grid">
                    @foreach($products as $p)
                        @include('partials.product-card', ['p' => $p])
                    @endforeach
                </div>
            @else
                <div class="empty-state"><div class="ic">🔍</div><h3>{{ __('messages.no_products') }}</h3></div>
            @endif
        </div>

        {{-- ===== other categories ===== --}}
        @if($others->count())
            <section class="section" style="padding-top:0">
                <div class="section-head reveal">
                    <div class="ornament"><span>❖</span></div>
                    <h2 class="grad-title">{{ __('messages.cat_title') }}</h2>
                </div>
                <div class="cat-grid">
                    @foreach($others as $c)
                        <a class="cat-card lux reveal" href="{{ route('category', $c->slug) }}">
                            <span class="cat-count">@num($c->products_count) {{ __('messages.items') }}</span>
                            <img src="{{ asset($c->image) }}" alt="{{ $c->name }}" loading="lazy">
                            <div class="overlay"><h3>{{ $c->name }}</h3><p>{{ $c->desc }}</p></div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
