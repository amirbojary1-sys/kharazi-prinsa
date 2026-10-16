<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('messages.brand') }} — {{ __('messages.footer_tag') }}">
    <title>@yield('title', __('messages.brand'))</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='6' fill='%23157A4B'/%3E%3Cpath d='M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z' fill='%23C7F0D8'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cinematic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/wow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/story.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pay.css') }}">
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('prinsa_theme') || 'light');
    </script>
</head>
<body>

<div id="preloader">
    <div class="pre-inner">
        <div class="pre-ring"></div>
        <div class="pre-thread"></div>
        <b>{{ __('messages.brand') }}</b>
    </div>
</div>

<div id="scrollProgress"></div>

<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="{{ route('home') }}">
            <div class="logo-mark">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z" fill="#C7F0D8"/><rect x="4.8" y="18" width="14.4" height="2.2" rx="1" fill="#C7F0D8"/></svg>
            </div>
            <div class="logo-text"><b>{{ __('messages.brand') }}</b><span>{{ __('messages.brandSub') }}</span></div>
        </a>

        <nav class="main-nav" id="mainNav">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.nav_home') }}</a>

            {{-- ========== MEGA MENU ========== --}}
            <div class="has-mega">
                <a href="{{ route('shop') }}" class="mega-trigger {{ request()->routeIs('shop') || request()->routeIs('product') ? 'active' : '' }}">
                    {{ __('messages.nav_shop') }} <span class="chev">▾</span>
                </a>
                <div class="mega-menu">
                    <div class="mega-fade-line"></div>
                    <div class="container mega-inner">
                        <div class="mega-cols">
                            @foreach($megaCategories as $c)
                                <div class="mega-col">
                                    <h5>
                                        <span class="mi">{{ mb_substr($c->name, 0, 1) }}</span>
                                        <a href="{{ route('category', $c->slug) }}" style="font-weight:800">{{ $c->name }}</a>
                                    </h5>
                                    @foreach($c->subcategories as $s)
                                        <a href="{{ route('category', ['slug' => $c->slug, 'sub' => $s->slug]) }}">{{ $s->name }}</a>
                                    @endforeach
                                    <a class="all-link" href="{{ route('category', $c->slug) }}">{{ __('messages.view_all') }} ({{ \App\Support\Fmt::num($c->products_count) }}) →</a>
                                </div>
                            @endforeach
                        </div>
                        <a class="mega-feature" href="{{ route('shop') }}">
                            <img src="{{ asset('images/banner-story.jpg') }}" alt="{{ __('messages.brand') }}">
                            <div class="veil"></div>
                            <div class="mf-body">
                                <h4>👑 {{ __('messages.feat_title') }}</h4>
                                <p>{{ __('messages.hero_sub') }}</p>
                                <span class="btn btn-primary">{{ __('messages.hero_cta') }} ←</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('messages.nav_about') }}</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('messages.nav_contact') }}</a>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">{{ __('messages.nav_admin') }}</a>
        </nav>

        <div class="header-actions">
            @auth
                <div class="user-chip" title="{{ Auth::user()->name }}">
                    <span class="uc-avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    <span class="uc-name">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="lang-btn" title="{{ __('messages.logout_acc') }}">↪<span class="lang-text">{{ __('messages.logout_acc') }}</span></button>
                </form>
            @else
                <a class="lang-btn" href="{{ route('login') }}">👤<span class="lang-text">{{ __('messages.login') }}</span></a>
                <a class="btn btn-primary" style="padding:9px 18px;font-size:.85rem" href="{{ route('register') }}">{{ __('messages.register') }}</a>
            @endauth
            <a class="lang-btn" href="{{ route('lang', app()->getLocale() === 'fa' ? 'en' : 'fa') }}">
                🌐<span class="lang-text">{{ __('messages.otherLang') }}</span>
            </a>
            <button class="theme-btn" data-action="toggle-theme" title="{{ __('messages.theme_day') }} / {{ __('messages.theme_night') }}">
                <span id="themeIcon">🌙</span>
                <span class="theme-text" id="themeLabel" data-day="{{ __('messages.theme_day') }}" data-night="{{ __('messages.theme_night') }}">{{ __('messages.theme_night') }}</span>
            </button>
            <a class="icon-btn" href="{{ route('favorites') }}" title="{{ __('messages.fav_title') }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                @if(\App\Support\Favs::count() > 0)
                    <span class="cart-badge fav">@num(\App\Support\Favs::count())</span>
                @endif
            </a>
            <a class="icon-btn" href="{{ route('cart') }}" title="{{ __('messages.cart') }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                @if(\App\Support\Cart::count() > 0)
                    <span class="cart-badge">@num(\App\Support\Cart::count())</span>
                @endif
            </a>
            <button class="icon-btn burger" data-action="toggle-menu" aria-label="menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>
</header>

<main id="app">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <div class="logo">
                <div class="logo-mark">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 8l3.5 3L12 5l5.5 6L21 8l-1.8 10H4.8L3 8z" fill="#C7F0D8"/><rect x="4.8" y="18" width="14.4" height="2.2" rx="1" fill="#C7F0D8"/></svg>
                </div>
                <div class="logo-text"><b>{{ __('messages.brand') }}</b><span>{{ __('messages.brandSub') }}</span></div>
            </div>
            <p>{{ __('messages.footer_tag') }}</p>
            <div class="social-row">
                <a href="{{ route('contact') }}" title="Instagram">📷</a>
                <a href="{{ route('contact') }}" title="Telegram">✈️</a>
                <a href="{{ route('contact') }}" title="WhatsApp">💬</a>
            </div>
        </div>

        <div class="footer-col">
            <button class="footer-toggle">{{ __('messages.footer_menu') }} <span class="chev">▾</span></button>
            <div class="footer-body">
                <h4>{{ __('messages.footer_links') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a></li>
                    <li><a href="{{ route('shop') }}">{{ __('messages.nav_shop') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('messages.nav_about') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('messages.nav_contact') }}</a></li>
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('messages.nav_admin') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-col">
            <button class="footer-toggle">{{ __('messages.footer_contact') }} <span class="chev">▾</span></button>
            <div class="footer-body">
                <h4>{{ __('messages.footer_contact') }}</h4>
                <ul class="footer-contact-list">
                    <li>📍 {{ __('messages.contact_addr') }}</li>
                    <li>📞 <a href="tel:+982144556677">{{ __('messages.contact_phone') }}</a></li>
                    <li>🕐 {{ __('messages.contact_hours') }}</li>
                    <li>💬 {{ __('messages.contact_social_t') }}: Instagram / Telegram / WhatsApp</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© @num(now()->year) {{ __('messages.brand') }} — {{ __('messages.rights') }}</span>
        <span>{{ __('messages.brandSub') }}</span>
    </div>
</footer>

<a class="float-call" href="tel:+982144556677" title="{{ __('messages.contact_phone_t') }}">📞</a>

@include('partials.mini-cart')

<div class="toast-wrap" id="toastWrap">
    @if(session('ok'))
        <div class="toast ok">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
        <div class="toast err">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="toast err">{{ $errors->first() }}</div>
    @endif
</div>
<div id="modalWrap"></div>

<script>
    (function () {
        var mc = document.getElementById('miniCart');
        var ov = document.getElementById('mcOverlay');
        if (!mc) return;
        function open() { mc.classList.add('open'); ov.classList.add('on'); mc.setAttribute('aria-hidden', 'false'); }
        function close() { mc.classList.remove('open'); ov.classList.remove('on'); mc.setAttribute('aria-hidden', 'true'); }
        document.getElementById('mcClose') && document.getElementById('mcClose').addEventListener('click', close);
        ov && ov.addEventListener('click', close);
        var q = new URLSearchParams(location.search);
        if (q.get('added') === '1' || {{ session('added') ? 'true' : 'false' }}) open();
    })();
</script>
<script src="{{ asset('js/fx.js') }}"></script>
<script src="{{ asset('js/wow.js') }}"></script>
</body>
</html>
