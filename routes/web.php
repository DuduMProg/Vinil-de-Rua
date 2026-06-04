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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;



// ── PÚBLICAS ──────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/tag/show/{tag}', [TagController::class, 'show'])->name('tag.show');

Route::get('/spotify/token', [SpotifyController::class, 'token'])->name('spotify.token');

Route::get('two-factor', [TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('two-factor', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');


// ── AUTENTICADAS ──────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {


    // Perfil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subpáginas do perfil
    Route::get('/profile/orders', fn() => view('profile.orders'))->name('profile.orders');
    Route::get('/profile/recent', fn() => view('profile.recently-viewed'))->name('profile.recent');

    // Carrinho
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');
    Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/decrement/{product}', [CartController::class, 'decrement'])->name('cart.decrement');
    Route::post('/cart/delete/{product}', [CartController::class, 'delete'])->name('cart.delete');

    //CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');


    // Favoritos
    Route::get('/whishlist', [WishlistController::class, 'index'])->name('whishlist.index');
    Route::post('/whishlist/store/{product}', [WishlistController::class, 'store'])->name('whishlist.store');
    Route::post('/whishlist/delete/{product}', [WishlistController::class, 'delete'])->name('whishlist.delete');

});


// ── ADMIN ─────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/orders/{order}/approve', [AdminController::class, 'approveOrder'])->name('orders.approve');
    Route::patch('/orders/{order}/cancel', [AdminController::class, 'cancelOrder'])->name('orders.cancel');

    Route::resource('product', ProductController::class)
        ->except(['index', 'show'])
        ->names([
            'create'  => 'product.create',
            'store'   => 'product.store',
            'edit'    => 'product.edit',
            'update'  => 'product.update',
            'destroy' => 'product.destroy',
        ]);

    Route::resource('category', CategoryController::class)
        ->except(['show'])
        ->names([
            'index'   => 'category.index',
            'create'  => 'category.create',
            'store'   => 'category.store',
            'edit'    => 'category.edit',
            'update'  => 'category.update',
            'destroy' => 'category.destroy',
        ]);

    Route::resource('tag', TagController::class)
        ->names([
            'index'   => 'tag.index',
            'create'  => 'tag.create',
            'store'   => 'tag.store',
            'edit'    => 'tag.edit',
            'update'  => 'tag.update',
            'destroy' => 'tag.destroy',
        ]);

});


require __DIR__ . '/auth.php';