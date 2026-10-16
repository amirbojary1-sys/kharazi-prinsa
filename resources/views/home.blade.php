@extends('layouts.app')

@section('title', __('messages.brand'))

@section('content')
    {{-- ================= PHOTO STORY — TOP cinematic scroll ================= --}}
    <section class="photo-story" data-photo-story>
        <div class="ps-sticky">
            <div class="ps-slides">
                <div class="ps-slide" data-ps>
                    <div class="bg" style="background-image:url('{{ asset('images/banner-atelier.jpg') }}')"></div>
                    <div class="veil"></div>
                </div>
                <div class="ps-slide" data-ps>
                    <div class="bg" style="background-image:url('{{ asset('images/hero-cinematic.jpg') }}')"></div>
                    <div class="veil"></div>
                </div>
                <div class="ps-slide" data-ps>
                    <div class="bg" style="background-image:url('{{ asset('images/banner-story.jpg') }}')"></div>
                    <div class="veil"></div>
                </div>
                <div class="ps-slide" data-ps>
                    <div class="bg" style="background-image:url('{{ asset('images/cat-ribbons.jpg') }}')"></div>
                    <div class="veil"></div>
                </div>
            </div>

            <div class="ps-caption">
                <div class="ps-cap active" data-ps-cap="0">
                    <div class="container"><div class="inner">
                        <div class="slide-no">01 / 04</div>
                        <div class="hero-kicker">✨ {{ __('messages.hero_kicker') }}</div>
                        <h1>{!! str_replace(['دوخت', 'stitches'], ['<em>دوخت</em>', '<em>stitches</em>'], __('messages.hero_title')) !!}</h1>
                        <p>{{ __('messages.hero_sub') }}</p>
                        <div class="btn-row">
                            <a class="btn btn-primary btn-sweep" href="{{ route('shop') }}">{{ __('messages.hero_cta') }} ←</a>
                            <a class="btn btn-ghost" href="{{ route('categories') }}">{{ __('messages.cat_title') }}</a>
                        </div>
                    </div></div>
                </div>
                <div class="ps-cap" data-ps-cap="1">
                    <div class="container"><div class="inner">
                        <div class="slide-no">02 / 04</div>
                        <div class="hero-kicker">📖 {{ __('messages.story_kicker') }}</div>
                        <h2>{{ __('messages.story_t1') }}</h2>
                        <p>{{ __('messages.story_d1') }}</p>
                    </div></div>
                </div>
                <div class="ps-cap" data-ps-cap="2">
                    <div class="container"><div class="inner">
                        <div class="slide-no">03 / 04</div>
                        <div class="hero-kicker">📖 {{ __('messages.story_kicker') }}</div>
                        <h2>{{ __('messages.story_t2') }}</h2>
                        <p>{{ __('messages.story_d2') }}</p>
                    </div></div>
                </div>
                <div class="ps-cap" data-ps-cap="3">
                    <div class="container"><div class="inner">
                        <div class="slide-no">04 / 04</div>
                        <div class="hero-kicker">📖 {{ __('messages.story_kicker') }}</div>
                        <h2>{{ __('messages.story_t3') }}</h2>
                        <p>{{ __('messages.story_d3') }}</p>
                        <div class="btn-row">
                            <a class="btn btn-primary btn-sweep" href="{{ route('shop') }}">{{ __('messages.hero_cta') }} ←</a>
                            <a class="btn btn-ghost" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                        </div>
                    </div></div>
                </div>
            </div>

            <div class="ps-bar"><i class="on"></i><i></i><i></i><i></i></div>
        </div>
    </section>

    {{-- ================= marquee ticker ================= --}}
    <div class="cine-marquee" aria-hidden="true">
        <div class="track">
            <span>
                ✂️ {{ __('messages.strip2_t') }} <i class="dot-sep">◆</i>
                🧵 {{ __('messages.cat_title') }} <i class="dot-sep">◆</i>
                🎀 {{ __('messages.strip4_t') }} <i class="dot-sep">◆</i>
                🚚 {{ __('messages.strip1_t') }} <i class="dot-sep">◆</i>
                💎 {{ __('messages.brand') }} <i class="dot-sep">◆</i>
                ✂️ {{ __('messages.strip2_t') }} <i class="dot-sep">◆</i>
                🧵 {{ __('messages.cat_title') }} <i class="dot-sep">◆</i>
                🎀 {{ __('messages.strip4_t') }} <i class="dot-sep">◆</i>
                🚚 {{ __('messages.strip1_t') }} <i class="dot-sep">◆</i>
                💎 {{ __('messages.brand') }} <i class="dot-sep">◆</i>
            </span>
            <span>
                ✂️ {{ __('messages.strip2_t') }} <i class="dot-sep">◆</i>
                🧵 {{ __('messages.cat_title') }} <i class="dot-sep">◆</i>
                🎀 {{ __('messages.strip4_t') }} <i class="dot-sep">◆</i>
                🚚 {{ __('messages.strip1_t') }} <i class="dot-sep">◆</i>
                💎 {{ __('messages.brand') }} <i class="dot-sep">◆</i>
                ✂️ {{ __('messages.strip2_t') }} <i class="dot-sep">◆</i>
                🧵 {{ __('messages.cat_title') }} <i class="dot-sep">◆</i>
                🎀 {{ __('messages.strip4_t') }} <i class="dot-sep">◆</i>
                🚚 {{ __('messages.strip1_t') }} <i class="dot-sep">◆</i>
                💎 {{ __('messages.brand') }} <i class="dot-sep">◆</i>
            </span>
        </div>
    </div>

    {{-- ================= categories — editorial mosaic ================= --}}
    <section class="section">
        <div class="container">
            <div class="section-head reveal">
                <div class="ornament"><span>❖</span></div>
                <div class="eyebrow">Prinsa Collections</div>
                <h2 class="grad-title">{{ __('messages.cat_title') }}</h2>
                <div class="stitch"></div>
                <p>{{ __('messages.cat_sub') }}</p>
            </div>
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
                                @foreach($c->subcategories->take(4) as $s)
                                    <span onclick="event.preventDefault();location.href='{{ route('category', ['slug' => $c->slug, 'sub' => $s->slug]) }}'">{{ $s->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="text-align:center;margin-top:8px" class="reveal">
                <a class="btn btn-green btn-sweep" href="{{ route('categories') }}">{{ __('messages.view_all') }} →</a>
            </div>
        </div>
    </section>

    {{-- ================= featured — 3D COVERFLOW ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-head reveal">
                <div class="ornament"><span>❖</span></div>
                <div class="eyebrow">Best sellers</div>
                <h2 class="grad-title">{{ __('messages.feat_title') }}</h2>
                <div class="stitch"></div>
                <p>{{ __('messages.feat_sub') }}</p>
            </div>

            <div class="coverflow reveal-zoom" id="coverflow">
                <button class="cf-nav prev" data-cf-prev aria-label="prev">‹</button>
                <div class="cf-stage" data-cf-stage>
                    @foreach($featured->take(6) as $p)
                        <div class="cf-item" data-cf-item>
                            <div class="cf-glow"></div>
                            <div class="cf-card">
                                <img src="{{ asset($p->image) }}" alt="{{ $p->name }}">
                                <div class="cf-info">
                                    <h3>{{ $p->name }}</h3>
                                    <div class="price">@price($p->price) <small>{{ \App\Support\Fmt::toman() }}</small></div>
                                    <a class="btn btn-primary" href="{{ route('product', $p->id) }}">{{ __('messages.view_details') }} ←</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="cf-nav next" data-cf-next aria-label="next">›</button>
                <div class="cf-dots" data-cf-dots></div>
            </div>

            <div style="text-align:center;margin-top:36px" class="reveal">
                <a class="btn btn-green btn-sweep" href="{{ route('shop') }}">{{ __('messages.view_all') }} →</a>
            </div>
        </div>
    </section>

    {{-- ================= cinematic parallax banner ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="cine-banner reveal-zoom">
                <div class="bg" data-bg-parallax="0.12" style="background-image:url('{{ asset('images/banner-story.jpg') }}')"></div>
                <div class="veil"></div>
                <div class="content">
                    <div class="badge-row">
                        <span>👑 PRINSA COLLECTION</span>
                        <span>✦ EST. 2026</span>
                    </div>
                    <div class="hero-kicker">👑 {{ __('messages.brand') }}</div>
                    <h2>{{ __('messages.about_title') }}</h2>
                    <p>{{ __('messages.about_p1') }}</p>
                    <a class="btn btn-primary btn-sweep" href="{{ route('about') }}">{{ __('messages.hero_cta2') }} ←</a>
                    <div class="stats">
                        <div class="st"><b data-count="{{ \App\Models\Product::count() }}">0</b><span>{{ __('messages.stat_products') }}</span></div>
                        <div class="st"><b data-count="{{ \App\Models\Subcategory::count() }}">0</b><span>{{ __('messages.filter_cats') }}</span></div>
                        <div class="st"><b data-count="1500">0</b><span>{{ __('messages.stat_customers') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= subcategory showcase ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-head reveal">
                <div class="ornament"><span>❖</span></div>
                <div class="eyebrow">Sub collections</div>
                <h2 class="grad-title">{{ __('messages.filter_cats') }}</h2>
                <div class="stitch"></div>
            </div>
            <div class="sub-pills" style="justify-content:center">
                @foreach($subcategories as $s)
                    <a class="reveal-zoom" href="{{ route('category', ['slug' => $s->category->slug, 'sub' => $s->slug]) }}">
                        {{ $s->name }} · @num($s->products_count)
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= COLOR STUDIO ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="studio reveal-left">
                <div class="studio-img">
                    <img id="studioImg" src="{{ asset('images/cat-ribbons.jpg') }}" alt="{{ __('messages.brand') }}">
                    <div class="tagline">🎨 Prinsa Color Studio</div>
                </div>
                <div class="studio-panel">
                    <div class="eyebrow" style="color:var(--green-600);letter-spacing:2px;font-size:.78rem;font-weight:800">LIVE PREVIEW</div>
                    <h2 class="grad-title">{{ __('messages.brand') }} ✨</h2>
                    <p>{{ __('messages.why2_d') }}</p>
                    <div class="studio-color-name" id="studioColorName"></div>
                    <div class="swatches">
                        <button data-hue="0"   data-sat="1.15" data-name=" Emerald · زمردی" style="background:linear-gradient(135deg,#1E9E5A,#0F5137)" class="active"></button>
                        <button data-hue="-60" data-sat="1.2"  data-name=" Rose · رز" style="background:linear-gradient(135deg,#E8A0B4,#B76E79)"></button>
                        <button data-hue="40"  data-sat="1.25" data-name=" Gold · طلایی" style="background:linear-gradient(135deg,#E0BE6E,#C9A227)"></button>
                        <button data-hue="175" data-sat="1.1"  data-name=" Sapphire · یاقوتی" style="background:linear-gradient(135deg,#5BA8D9,#1F5F8B)"></button>
                        <button data-hue="280" data-sat="1.15" data-name=" Amethyst · آمیتیست" style="background:linear-gradient(135deg,#A87BD9,#5B2E86)"></button>
                        <button data-hue="20"  data-sat="1.3"  data-name=" Coral · مرجانی" style="background:linear-gradient(135deg,#FF9E7D,#E0603E)"></button>
                    </div>
                    <div class="studio-hint">{{ __('messages.scroll_hint') }} · 6 ✨</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= photo gallery ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-head reveal">
                <div class="ornament"><span>❖</span></div>
                <div class="eyebrow">Gallery</div>
                <h2 class="grad-title">{{ __('messages.gallery_title') }}</h2>
                <div class="stitch"></div>
                <p>{{ __('messages.gallery_sub') }}</p>
            </div>
            <div class="photo-gallery">
                @foreach(['prod-macro-buttons', 'prod-macro-ribbon', 'prod-scissors', 'prod-lace', 'prod-embroidery', 'prod-giftbox'] as $g)
                    <div class="pg-item reveal-zoom">
                        <img src="{{ asset("images/{$g}.jpg") }}" alt="{{ __('messages.gallery_title') }}" loading="lazy">
                        <div class="pg-veil"><span>✦</span></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= testimonials ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="section-head reveal">
                <div class="ornament"><span>❖</span></div>
                <div class="eyebrow">Reviews</div>
                <h2 class="grad-title">{{ __('messages.rev_title') }}</h2>
                <div class="stitch"></div>
                <p>{{ __('messages.rev_sub') }}</p>
            </div>
            <div class="review-grid">
                @foreach([1, 2, 3] as $i)
                    <div class="review-card reveal" data-delay="{{ $i - 1 }}">
                        <div class="stars">★★★★★</div>
                        <p class="quote">{{ __('messages.rev' . $i . '_text') }}</p>
                        <div class="who">
                            <span class="avatar">{{ mb_substr(__('messages.rev' . $i . '_name'), 0, 1) }}</span>
                            <div>
                                <b>{{ __('messages.rev' . $i . '_name') }}</b>
                                <small>✓ {{ __('messages.verified_buyer') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= why us ================= --}}
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="why reveal">
                <div class="fx-stage" aria-hidden="true">
                    <div class="fx-shape fx-ring" data-speed="0.08" data-rot="0.03" style="width:180px;height:180px;top:-40px;inset-inline-end:-40px;opacity:.18"></div>
                    <div class="fx-shape fx-star" data-speed="0.2" data-rot="0.08" style="width:64px;height:64px;bottom:8%;inset-inline-start:4%;opacity:.25"></div>
                </div>
                <div class="why-wrap">
                    <div class="section-head">
                        <h2>{{ __('messages.why_title') }}</h2>
                    </div>
                    <div class="why-grid">
                        <div class="why-card tilt"><div class="tilt-inner"><div class="ic">✦</div><h3>{{ __('messages.why1_t') }}</h3><p>{{ __('messages.why1_d') }}</p></div></div>
                        <div class="why-card tilt"><div class="tilt-inner"><div class="ic">❖</div><h3>{{ __('messages.why2_t') }}</h3><p>{{ __('messages.why2_d') }}</p></div></div>
                        <div class="why-card tilt"><div class="tilt-inner"><div class="ic">◈</div><h3>{{ __('messages.why3_t') }}</h3><p>{{ __('messages.why3_d') }}</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
