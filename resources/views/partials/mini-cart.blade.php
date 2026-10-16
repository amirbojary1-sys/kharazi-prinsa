{{-- slide-over mini cart drawer (opens after add-to-cart via ?added=1 / flash) --}}
@php($mcItems = \App\Support\Cart::lines())
<aside class="mini-cart" id="miniCart" aria-hidden="true">
    <div class="mini-cart-head">
        <h3>{{ __('messages.mini_cart_title') }} <span class="mc-count">@num(\App\Support\Cart::count())</span></h3>
        <button class="mc-close" id="mcClose" aria-label="close">✕</button>
    </div>
    <div class="mini-cart-body">
        @forelse($mcItems as $line)
            <div class="mc-item">
                <img src="{{ asset($line->product->image) }}" alt="">
                <div>
                    <b>{{ $line->product->name }}@if($line->variant) ({{ $line->variant->name }})@endif</b>
                    <span>@num($line->qty) × @price($line->price)</span>
                </div>
            </div>
        @empty
            <p class="mc-empty">{{ __('messages.cart_empty') }}</p>
        @endforelse
    </div>
    <div class="mini-cart-foot">
        <div class="mc-total"><span>{{ __('messages.subtotal') }}</span><b>@price(\App\Support\Cart::subtotal()) {{ \App\Support\Fmt::toman() }}</b></div>
        <a href="{{ route('cart') }}" class="btn btn-green" style="width:100%;justify-content:center">{{ __('messages.mini_cart_view') }}</a>
        @if(\App\Support\Cart::count())
            <a href="{{ route('checkout') }}" class="btn btn-primary" style="width:100%;justify-content:center">{{ __('messages.checkout') }}</a>
        @endif
    </div>
</aside>
<div class="mini-cart-overlay" id="mcOverlay"></div>
