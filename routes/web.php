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

/* ---------- cart + checkout ---------- */
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
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

    Route::get('/settings', [AdminController::class, 'settingsForm'])->name('settings');
    Route::post('/settings', [AdminController::class, 'settingsSave'])->name('settings.save');
});
