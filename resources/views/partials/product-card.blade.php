{{-- product card: pass ['p' => $product] --}}
<article class="product-card lux scr-rotate">
    <div class="product-media" onclick="location.href='{{ route('product', $p->id) }}'">
        @if($p->featured)<span class="badge gold">⭐</span>@elseif($p->stock <= 0)<span class="badge dark">{{ __('messages.out_stock') }}</span>@endif
        <form method="POST" action="{{ route('favorites.toggle', $p->id) }}" class="fav-btn-wrap" onclick="event.stopPropagation()">
            @csrf
            <button class="fav-btn {{ \App\Support\Favs::has($p->id) ? 'on' : '' }}" title="{{ __('messages.fav_title') }}">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="{{ \App\Support\Favs::has($p->id) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
            </button>
        </form>
        <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" loading="lazy">
        <div class="quick" onclick="event.stopPropagation()">
            <a class="btn btn-primary" href="{{ route('product', $p->id) }}">{{ __('messages.view_details') }}</a>
            <form method="POST" action="{{ route('cart.add', $p->id) }}" style="flex:1">
                @csrf
                <button class="btn btn-ghost" style="width:100%" {{ $p->stock <= 0 ? 'disabled' : '' }}>{{ __('messages.add_cart') }}</button>
            </form>
        </div>
    </div>
    <div class="product-body">
        <h3 onclick="location.href='{{ route('product', $p->id) }}'">{{ $p->name }}</h3>
        @php($pcAvg = $p->avgRating())
        @if($pcAvg)
            <div class="pc-rating">
                <span class="stars">@for($i = 1; $i <= 5; $i++)<span class="star {{ $i <= round($pcAvg) ? 'fill' : '' }}">★</span>@endfor</span>
                <small>({{ \App\Support\Fmt::num($p->reviewsCount()) }})</small>
            </div>
        @endif
        <p class="desc">{{ $p->desc }}</p>
        <div class="product-foot">
            <div class="price">@price($p->price) <small>{{ \App\Support\Fmt::toman() }}</small></div>
            <form method="POST" action="{{ route('cart.add', $p->id) }}">
                @csrf
                <button class="btn-add" {{ $p->stock <= 0 ? 'disabled' : '' }} title="{{ __('messages.add_cart') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
            </form>
        </div>
    </div>
</article>
