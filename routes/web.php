<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartVariationController;
use App\Http\Controllers\CategoryShowController;
use App\Http\Controllers\ProductShowController;
use App\Http\Controllers\SearchController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', SearchController::class)->name('search');

Route::get('/products/{product:slug}', ProductShowController::class)->name('products.show');
Route::get('/categories/{category:slug}', CategoryShowController::class)->name('categories.show');

Route::prefix('/cart')
    ->group(function () {
        Route::get('/', CartController::class)
            ->name('cart.index');

        Route::post('/variations', [CartVariationController::class, 'store'])
            ->name('cart.variations.store');

        Route::patch('/variations/{variation}', [CartVariationController::class, 'update'])
            ->name('cart.variations.update');

        Route::delete('/variations/{variation}', [CartVariationController::class, 'destroy'])
            ->name('cart.variations.destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
