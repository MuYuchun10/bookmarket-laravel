<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');

Route::get('/catalog/{slug}', [ProductController::class, 'show'])->name('catalog.show');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
