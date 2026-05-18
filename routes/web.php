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




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //ROTAS DOS PRODUTOS
    Route::resource('product', ProductController::class);
    Route::get('/product/create', [ProductController::class, 'create']);
    Route::post('/product/store', [ProductController::class, 'store']);
    Route::get('/product/edit/{product}', [ProductController::class, 'edit']);
    Route::post('/product/update/{product}', [ProductController::class, 'update']);
    Route::get('/product/delete/{product}', [ProductController::class, 'delete']);


    //ROTAS DA CATEGORIA

    //CATEGORIA
    Route::resource('category', CategoryController::class);
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

    //VISUALIZAÇÃO
    Route::get('/product/show/{product}', [ProductController::class, 'show']);

    //ROTAS DA Tag


    Route::resource('tag', TagController::class);
    Route::get('/tag', [TagController::class, 'index']);
    Route::get('/tag/create', [TagController::class, 'create']);
    Route::post('/tag/store', [TagController::class, 'store']);
    Route::get('/tag/show/{tag}', [TagController::class, 'show']);  
    Route::get('/tag/edit/{tag}', [TagController::class, 'edit']);
    Route::post('/tag/update/{tag}', [TagController::class, 'update']);
    Route::get('/tag/delete/{tag}', [TagController::class, 'delete']);




    //CARRINHO
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar'); // nova
    Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/decrement/{product}', [CartController::class, 'decrement'])->name('cart.decrement');
    Route::post('/cart/delete/{product}', [CartController::class, 'delete'])->name('cart.delete');
});

Route::get('/', [HomeController::class, 'index']);

//SPOTIFY
Route::get('/spotify/token', [SpotifyController::class, 'token'])->name('spotify.token');

//FAVORITO
Route::get('/whishlist', [WishlistController::class, 'index'])->name('whishlist.index');
Route::post('/whishlist/store/{product}', [WishlistController::class, 'store'])->name('whishlist.store');
Route::post('/whishlist/delete/{product}', [WishlistController::class, 'delete'])->name('whishlist.delete');



Route::get('/product', [ProductController::class, 'index']);
require __DIR__ . '/auth.php';


Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');



Route::get('two-factor', [TwoFactorController::class, 'show'])
    ->name('2fa.show');
Route::post('two-factor', [TwoFactorController::class, 'verify'])
    ->name('2fa.verify');
Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])
    ->name('2fa.resend');


