<?php

use App\Http\Controllers\CartVariationController;
use App\Http\Controllers\ProductShowController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', HomeController::class)->name('home');

Route::get('/products/{product:slug}', ProductShowController::class);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])
    ->prefix('/cart')
    ->group(function () {
        // Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/variations', [CartVariationController::class, 'store'])->name('cart.variations.store');
//        Route::delete('/products/{product:slug}', [CartProductController::class, 'destroy'])->name(
//            'cart.products.destroy'
//        );
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
