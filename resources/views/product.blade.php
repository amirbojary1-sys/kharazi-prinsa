@extends('layouts.app')

@section('title', $product->name)

@section('meta_desc')
{{ \Illuminate\Support\Str::limit(strip_tags($product->desc), 155) }}
@endsection

@section('og_image'){{ asset($product->image) }}@endsection

@php($ogType = 'product')
@php($jsonLd = [
    \App\Support\SEO::productSchema($product),
    \App\Support\SEO::breadcrumbSchema([
        ['name' => __('messages.nav_home'), 'url' => route('home')],
        ['name' => $product->category->name, 'url' => route('category', $product->category->slug)],
        ['name' => $product->name],
    ]),
])

@php($gallery = $product->gallery())
@php($avg = $product->avgRating())
@php($revCount = $product->reviewsCount())

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
            <div class="pd-zoom" id="pdZoom">
                <img src="{{ asset($gallery[0]) }}" alt="{{ $product->name }}" id="pdMainImg">
            </div>
            @if(count($gallery) > 1)
                <div class="pd-thumbs" id="pdThumbs">
                    @foreach($gallery as $i => $img)
                        <button type="button" class="pd-thumb {{ $i === 0 ? 'on' : '' }}" data-src="{{ asset($img) }}">
                            <img src="{{ asset($img) }}" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="pd-info reveal" data-delay="1">
            <span class="pd-cat">{{ $product->category->name }}{{ $product->subcategory ? ' · ' . $product->subcategory->name : '' }}</span>
            <h1>{{ $product->name }}</h1>

            <a class="pd-rating" href="#reviews">
                <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $avg && $i <= round($avg) ? 'fill' : '' }}">★</span>
                    @endfor
                </span>
                @if($avg)
                    <b>{{ \App\Support\Fmt::num($avg) }}</b>
                    <span>({{ __('messages.reviews_count', ['n' => \App\Support\Fmt::num($revCount)]) }})</span>
                @else
                    <span>{{ __('messages.no_reviews_yet') }}</span>
                @endif
            </a>

            <div class="pd-price"><span id="pdPrice">@price($product->price)</span> <small>{{ \App\Support\Fmt::toman() }}</small></div>
            <p class="pd-desc">{{ $product->desc }}</p>

            @if($product->variants->count())
                <div class="pd-variants">
                    <label>{{ __('messages.choose_variant') }}</label>
                    <div class="variant-chips" id="variantChips">
                        @foreach($product->variants as $i => $v)
                            <button type="button"
                                    class="v-chip {{ $i === 0 ? 'on' : '' }}"
                                    data-id="{{ $v->id }}"
                                    data-delta="{{ $v->price_delta }}"
                                    data-stock="{{ $v->stock }}"
                                    {{ $v->stock <= 0 ? 'disabled' : '' }}>
                                {{ $v->name }}
                                @if($v->price_delta)
                                    <small>{{ ($v->price_delta > 0 ? '+' : '−') . \App\Support\Fmt::price(abs($v->price_delta)) }}</small>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}" id="variantInput">
                </div>
            @endif

            <div class="pd-stock {{ $product->stock <= 0 ? 'out' : '' }}" id="pdStock">
                {{ $product->stock <= 0 ? '✕ ' . __('messages.out_stock') : '✓ ' . __('messages.stock_left') . ' (' . \App\Support\Fmt::num($product->stock) . ')' }}
            </div>

            <form method="POST" action="{{ route('favorites.toggle', $product->id) }}" id="favForm" style="display:none">@csrf</form>
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="pd-actions" id="pdBuyForm">
                @csrf
                <input type="hidden" name="variant_id" value="" id="variantBuyInput">
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

    {{-- ============ reviews ============ --}}
    <section class="section" id="reviews" style="padding-top:36px">
        <div class="section-head reveal"><h2>⭐ {{ __('messages.reviews_title') }}</h2></div>

        <div class="reviews-layout">
            <div class="review-list reveal">
                @forelse($product->approvedReviews as $r)
                    <div class="review-card">
                        <div class="rc-head">
                            <span class="rc-avatar">{{ mb_substr($r->author_name, 0, 1) }}</span>
                            <div>
                                <b>{{ $r->author_name }}</b>
                                <span class="rc-date">{{ \App\Support\Fmt::date($r->created_at) }}</span>
                            </div>
                            <span class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $r->rating ? 'fill' : '' }}">★</span>
                                @endfor
                            </span>
                        </div>
                        <p>{{ $r->comment }}</p>
                    </div>
                @empty
                    <p class="muted-box">{{ __('messages.no_reviews_yet') }}</p>
                @endforelse
            </div>

            <div class="review-form-card reveal" data-delay="1">
                <h3>{{ __('messages.review_write') }}</h3>
                <form method="POST" action="{{ route('reviews.store', $product->id) }}">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.rating') }}</label>
                        <div class="rate-input" id="rateInput">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="rate{{ $i }}" {{ $i === 5 ? 'checked' : '' }}>
                                <label for="rate{{ $i }}">★</label>
                            @endfor
                        </div>
                    </div>
                    @guest
                        <div class="form-group">
                            <label>{{ __('messages.rev_author') }}</label>
                            <input class="form-input" name="name" value="{{ old('name') }}" maxlength="120">
                        </div>
                    @endguest
                    <div class="form-group">
                        <label>{{ __('messages.rev_comment') }}</label>
                        <textarea class="form-input" name="comment" rows="4" required minlength="5" maxlength="1000">{{ old('comment') }}</textarea>
                    </div>
                    <button class="btn btn-green" style="width:100%;justify-content:center">{{ __('messages.review_submit') }}</button>
                    @guest
                        <p style="font-size:.76rem;color:var(--muted);margin-top:8px">{{ __('messages.review_guest_note') }}</p>
                    @endguest
                </form>
            </div>
        </div>
    </section>

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

<script>
    (function () {
        // gallery thumbs
        var main = document.getElementById('pdMainImg');
        document.querySelectorAll('#pdThumbs .pd-thumb').forEach(function (t) {
            t.addEventListener('click', function () {
                document.querySelectorAll('#pdThumbs .pd-thumb').forEach(function (x) { x.classList.remove('on'); });
                t.classList.add('on');
                main.src = t.dataset.src;
            });
        });

        // hover zoom (magnifier)
        var zoom = document.getElementById('pdZoom');
        if (zoom && main) {
            zoom.addEventListener('mousemove', function (e) {
                var r = zoom.getBoundingClientRect();
                var x = ((e.clientX - r.left) / r.width) * 100;
                var y = ((e.clientY - r.top) / r.height) * 100;
                main.style.transformOrigin = x + '% ' + y + '%';
                main.classList.add('zooming');
            });
            zoom.addEventListener('mouseleave', function () { main.classList.remove('zooming'); });
        }

        // variants
        var chips = document.querySelectorAll('#variantChips .v-chip');
        var priceEl = document.getElementById('pdPrice');
        var base = {{ $product->price }};
        var vInput = document.getElementById('variantInput');
        var vBuy = document.getElementById('variantBuyInput');
        var fmt = function (n) { return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ','); };
        chips.forEach(function (c) {
            c.addEventListener('click', function () {
                chips.forEach(function (x) { x.classList.remove('on'); });
                c.classList.add('on');
                var delta = parseInt(c.dataset.delta, 10) || 0;
                if (priceEl) priceEl.textContent = fmt(base + delta);
                if (vInput) vInput.value = c.dataset.id;
                if (vBuy) vBuy.value = c.dataset.id;
                var stock = parseInt(c.dataset.stock, 10);
                var stockEl = document.getElementById('pdStock');
                if (stockEl) {
                    if (stock <= 0) {
                        stockEl.textContent = '✕ {{ __('messages.out_stock') }}';
                        stockEl.classList.add('out');
                    } else {
                        stockEl.textContent = '✓ {{ __('messages.stock_left') }} (' + fmt(stock) + ')';
                        stockEl.classList.remove('out');
                    }
                }
            });
        });
        if (chips.length && vBuy) vBuy.value = document.querySelector('#variantChips .v-chip.on').dataset.id;
    })();
</script>
@endsection
