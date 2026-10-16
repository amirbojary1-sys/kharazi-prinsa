<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;


/* ---------- SEO: sitemap.xml ---------- */
Route::get('/sitemap.xml', function () {
    $products   = \App\Models\Product::orderBy('id')->get();
    $categories = \App\Models\Category::orderBy('id')->get();

    $urls = [
        ['loc' => route('home'),      'priority' => '1.0', 'changefreq' => 'daily'],
        ['loc' => route('shop'),      'priority' => '0.9', 'changefreq' => 'daily'],
        ['loc' => route('categories'),'priority' => '0.8', 'changefreq' => 'weekly'],
        ['loc' => route('about'),     'priority' => '0.5', 'changefreq' => 'monthly'],
        ['loc' => route('contact'),   'priority' => '0.5', 'changefreq' => 'monthly'],
        ['loc' => route('track'),     'priority' => '0.4', 'changefreq' => 'monthly'],
    ];
    foreach ($categories as $c) {
        $urls[] = ['loc' => route('category', $c->slug), 'priority' => '0.8', 'changefreq' => 'weekly'];
    }
    foreach ($products as $p) {
        $urls[] = ['loc' => route('product', $p->id), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => $p->updated_at->toDateString()];
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
    foreach ($urls as $u) {
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . $u['loc'] . "</loc>\n";
        if (!empty($u['lastmod'])) {
            $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
        }
        $xml .= '    <changefreq>' . $u['changefreq'] . "</changefreq>\n";
        $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
        $xml .= '    <xhtml:link rel="alternate" hreflang="fa" href="' . $u['loc'] . '?lang=fa"/>' . "\n";
        $xml .= '    <xhtml:link rel="alternate" hreflang="en" href="' . $u['loc'] . '?lang=en"/>' . "\n";
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

/* ---------- storefront ---------- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/lang/{locale}', [HomeController::class, 'lang'])->name('lang');

/* ---------- customer auth ---------- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ---------- catalog ---------- */
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/c/{slug}', [CategoryController::class, 'show'])->name('category');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('product');

/* ---------- favorites ---------- */
Route::post('/favorites/{id}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');

/* ---------- my account ---------- */
Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account')->middleware('auth');
Route::get('/account/order/{id}', [\App\Http\Controllers\AccountController::class, 'order'])->name('account.order')->middleware('auth');
Route::post('/account/profile', [\App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.profile')->middleware('auth');

/* ---------- order tracking (public) ---------- */
Route::get('/track', [\App\Http\Controllers\TrackController::class, 'show'])->name('track');
Route::post('/track', [\App\Http\Controllers\TrackController::class, 'lookup'])->name('track.lookup');

/* ---------- reviews ---------- */
Route::post('/product/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

/* ---------- cart + checkout ---------- */
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->where('key', '[0-9:]+')->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/{code}', [CheckoutController::class, 'success'])->name('order.success');

/* ---------- payment gateway ---------- */
Route::get('/pay/{code}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/pay/{code}/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/pay/{code}/callback', [PaymentController::class, 'callback'])->name('payment.callback.get');

/* ---------- admin ---------- */
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderShow'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('orders.status');

    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/customers/{id}', [AdminController::class, 'customerShow'])->name('customers.show');

    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
    Route::post('/coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
    Route::post('/coupons/{id}/toggle', [AdminController::class, 'toggleCoupon'])->name('coupons.toggle');
    Route::delete('/coupons/{id}', [AdminController::class, 'destroyCoupon'])->name('coupons.destroy');

    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{id}/status', [AdminController::class, 'reviewStatus'])->name('reviews.status');
    Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');

    Route::get('/settings', [AdminController::class, 'settingsForm'])->name('settings');
    Route::post('/settings', [AdminController::class, 'settingsSave'])->name('settings.save');
});
