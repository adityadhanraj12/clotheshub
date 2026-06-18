<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;

Route::get('/login', function () {
    return view('customer-login');
});
Route::get('/customer-order', function () {
    return view('customer-order');
});
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/', [RouteController::class, 'index'])->name('index');
Route::get('/index', [RouteController::class, 'index'])->name('index');
Route::get('/category', [RouteController::class, 'category'])->name('category');
Route::get('/detail', [RouteController::class, 'detail'])->name('detail');
Route::get('/cart', [RouteController::class, 'cart'])->name('cart');
Route::middleware('auth')->group(function () {
    Route::get('/checkout1', [RouteController::class, 'checkout1'])->name('checkout1');
    Route::get('/checkout2', [RouteController::class, 'checkout2'])->name('checkout2');
    Route::get('/checkout3', [RouteController::class, 'checkout3'])->name('checkout3');
    Route::get('/checkout4', [RouteController::class, 'checkout4'])->name('checkout4');
    Route::get('/checkout5', [RouteController::class, 'checkout5'])->name('checkout5');
    Route::post('/checkout1/save-address', [RouteController::class, 'saveAddress'])->name('checkout1.save');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
});
Route::get('/contact', [RouteController::class, 'contact'])->name('contact');
Route::get('/about', [RouteController::class, 'about'])->name('about');
Route::get('/faq', [RouteController::class, 'faq'])->name('faq');
Route::get('/comingSoon', [RouteController::class, 'comingSoon'])->name('comingSoon');
Route::get('/customerLogin', [RouteController::class, 'customerLogin'])->name('customerLogin');
Route::middleware('auth')->group(function () {
    Route::get('/customerOrders', [RouteController::class, 'customerOrders'])->name('customerOrders');
    Route::get('/customerAddresses', [RouteController::class, 'customerAddresses'])->name('customerAddresses');
    Route::get('/customerAccount', [ProfileController::class, 'index'])->name('customerAccount');
});
Route::middleware('auth')->group(function () {
    Route::get('/customerAccount', [ProfileController::class, 'index'])->name('customerAccount');
    Route::post('/customerAccount/update', [ProfileController::class, 'update'])->name('customerAccount.update');
    Route::delete('/customerAccount', [ProfileController::class, 'destroy'])->name('customerAccount.delete');
});
Route::post('/customer-profile-update', [ProfileController::class, 'update'])->name('customerProfile.update')->middleware('auth');
Route::get('/customer-orders', [RouteController::class, 'customerOrders'])->name('customer.orders');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('customerLogin');
})->name('logout');
Route::post('/customer/addresses/store', [CustomerAddressController::class, 'store'])->name('customerAddresses.store');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
Route::get('/category', [ShopController::class, 'index'])->name('category');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/order-success', function () {
    return view('checkout5');
})->middleware('auth')->name('order.success');
Route::post('/checkout3-submit', [RouteController::class, 'checkout3Submit'])->name('checkout3.submit');
Route::post('/checkout2/save', [CheckoutController::class, 'saveDeliveryMethod'])->name('checkout2.save');
Route::get('/customerOrders/{id}', [RouteController::class, 'customerOrderDetails'])->name('customerOrderDetails');
Route::post('/customerOrders/{id}/cancel', [CheckoutController::class, 'cancelOrder'])->name('customerOrder.cancel')->middleware('auth');
Route::get('/search', [ProductController::class, 'search'])->name('search');