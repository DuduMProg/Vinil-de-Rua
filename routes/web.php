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

// ── PÚBLICAS — qualquer visitante acessa 

Route::get('/', [HomeController::class, 'index']);

// Catálogo público
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Categorias públicas
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

// Tags públicas (página de ofertas etc)
Route::get('/tag/show/{tag}', [TagController::class, 'show']);

// Spotify token (JS precisa disso publicamente)
Route::get('/spotify/token', [SpotifyController::class, 'token'])->name('spotify.token');

// 2FA
Route::get('two-factor', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('two-factor', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');


// ── AUTENTICADAS — precisa estar logado 

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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


// ── ADMIN — só administradores 

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Produtos (CRUD completo)
    Route::resource('product', ProductController::class)
        ->except(['index', 'show']); // index e show são públicos

    // Categorias (CRUD completo)
    Route::resource('category', CategoryController::class)
        ->except(['show']); // show é público

    // Tags (CRUD completo)
    Route::resource('tag', TagController::class);

});


require __DIR__ . '/auth.php';