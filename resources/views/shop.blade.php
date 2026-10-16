@extends('layouts.app')

@section('title', __('messages.shop_title'))

@section('content')
<div class="container">
    <div class="page-head reveal">
        <div class="crumbs"><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a> / {{ __('messages.shop_title') }}</div>
        <h1 class="grad-title">{{ $activeCat === 'all' ? __('messages.shop_title') : ($categories->firstWhere('slug', $activeCat)?->name ?? __('messages.shop_title')) }}</h1>
    </div>

    <div class="shop-layout">
        <aside class="shop-side">
            <div class="side-box reveal">
                <h3>{{ __('messages.filter_cats') }}</h3>
                <div class="cat-list">
                    <a href="{{ route('shop', array_filter(['q' => $q, 'sort' => $sort])) }}" class="{{ $activeCat === 'all' ? 'active' : '' }}">{{ __('messages.all_cats') }}</a>
                    @foreach($categories as $c)
                        <a href="{{ route('shop', array_filter(['cat' => $c->slug, 'q' => $q, 'sort' => $sort])) }}" class="{{ $activeCat === $c->slug ? 'active' : '' }}">
                            {{ $c->name }} <small style="opacity:.65">(@num($c->products_count))</small>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div>
            {{-- subcategory pills --}}
            @if($subList->count())
                <div class="sub-pills">
                    <a href="{{ route('shop', array_filter(['cat' => $activeCat === 'all' ? null : $activeCat, 'q' => $q, 'sort' => $sort])) }}" class="{{ $activeSub === 'all' ? 'active' : '' }}">{{ __('messages.all_cats') }}</a>
                    @foreach($subList as $s)
                        <a href="{{ route('shop', array_filter(['cat' => $activeCat === 'all' ? null : $activeCat, 'sub' => $s->slug, 'q' => $q, 'sort' => $sort])) }}" class="{{ $activeSub === $s->slug ? 'active' : '' }}">
                            {{ $s->name }} · @num($s->products_count)
                        </a>
                    @endforeach
                </div>
            @endif

            <form class="shop-toolbar" method="GET" action="{{ route('shop') }}">
                @if($activeCat !== 'all')<input type="hidden" name="cat" value="{{ $activeCat }}">@endif
                @if($activeSub !== 'all')<input type="hidden" name="sub" value="{{ $activeSub }}">@endif
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input name="q" placeholder="{{ __('messages.search_ph') }}" value="{{ $q }}">
                </div>
                <select class="select-box" name="sort" onchange="this.form.submit()">
                    <option value="new" {{ $sort === 'new' ? 'selected' : '' }}>{{ __('messages.sort_new') }}</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>{{ __('messages.sort_price_asc') }}</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>{{ __('messages.sort_price_desc') }}</option>
                    <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>{{ __('messages.sort_name') }}</option>
                </select>
                <button class="btn btn-green btn-sweep" type="submit">🔍 {{ __('messages.search_btn') }}</button>
                <div class="result-count">@num($products->count()) {{ __('messages.results') }}</div>
            </form>

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
    </div>
</div>
@endsection
