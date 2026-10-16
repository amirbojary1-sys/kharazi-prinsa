@php($adminTabs = [
    ['admin.dashboard', '📊', 'admin_dash'],
    ['admin.products', '📦', 'admin_products'],
    ['admin.orders', '🧾', 'admin_orders'],
    ['admin.customers', '👥', 'admin_customers'],
    ['admin.coupons', '🏷️', 'admin_coupons'],
    ['admin.transactions', '💳', 'admin_transactions'],
    ['admin.reviews', '⭐', 'admin_reviews'],
    ['admin.settings', '⚙️', 'admin_settings'],
])
<div class="admin-topbar">
    <h2>👑 {{ session('admin_name', __('messages.brand')) }}</h2>
    <div class="admin-tabs">
        @foreach($adminTabs as [$route, $icon, $key])
            <a href="{{ route($route) }}" class="{{ request()->routeIs($route) ? 'active' : '' }}">{{ $icon }} {{ __('messages.' . $key) }}</a>
        @endforeach
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="mini-btn danger">{{ __('messages.admin_logout') }}</button>
        </form>
    </div>
</div>
