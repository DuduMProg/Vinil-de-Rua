<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\HomeController;

// ── PÚBLICAS ──────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index']);

// Catálogo público
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Categorias públicas
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

// Tags públicas
Route::get('/tag/show/{tag}', [TagController::class, 'show'])->name('tag.show');

// Spotify token
Route::get('/spotify/token', [SpotifyController::class, 'token'])->name('spotify.token');

// 2FA
Route::get('two-factor', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('two-factor', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');


// ── AUTENTICADAS ──────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    // Página principal do perfil (nova tela)
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    // Página de edição (mantém o Breeze)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Novas páginas
    Route::view('/profile/orders', 'profile.orders')
        ->name('profile.orders');

    Route::view('/profile/recent', 'profile.recent')
        ->name('profile.recent');

    Route::view('/profile/favorites', 'profile.favorites')
        ->name('profile.favorites');
    // Carrinho
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');
    Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/decrement/{product}', [CartController::class, 'decrement'])->name('cart.decrement');
    Route::post('/cart/delete/{product}', [CartController::class, 'delete'])->name('cart.delete');

    // Favoritos
    Route::get('/whishlist', [WishlistController::class, 'index'])->name('whishlist.index');
    Route::post('/whishlist/store/{product}', [WishlistController::class, 'store'])->name('whishlist.store');
    Route::post('/whishlist/delete/{product}', [WishlistController::class, 'delete'])->name('whishlist.delete');

});


// ── ADMIN ─────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Produtos
    Route::resource('product', ProductController::class)
        ->except(['index', 'show'])
        ->names([
            'create' => 'product.create',
            'store' => 'product.store',
            'edit' => 'product.edit',
            'update' => 'product.update',
            'destroy' => 'product.destroy',
        ]);

    // Categorias
    Route::resource('category', CategoryController::class)
        ->except(['show'])
        ->names([
            'index' => 'category.index',
            'create' => 'category.create',
            'store' => 'category.store',
            'edit' => 'category.edit',
            'update' => 'category.update',
            'destroy' => 'category.destroy',
        ]);

    // Tags
    Route::resource('tag', TagController::class)
        ->names([
            'index' => 'tag.index',
            'create' => 'tag.create',
            'store' => 'tag.store',
            'edit' => 'tag.edit',
            'update' => 'tag.update',
            'destroy' => 'tag.destroy',
        ]);

});


require __DIR__ . '/auth.php';