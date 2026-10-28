<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');

Route::get('/catalog/{slug}', [ProductController::class, 'show'])->name('catalog.show');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');

Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');


Route::middleware('guest')->group(function () {
    Route::get('/account', [AuthController::class, 'show'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

        Route::get('/products', [AdminProductController::class, 'index'])
            ->name('products.index');

        Route::post('/products', [AdminProductController::class, 'store'])
            ->name('products.store');
    });

Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])
    ->name('checkout.buy-now');

Route::get('/contacts', [ContactController::class, 'index'])
    ->name('contacts.index');

Route::post('/contacts', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contacts.store');
    