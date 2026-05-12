<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});

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


    //ROTAS DA CATEGORIA{

    //CRIAÇÃO
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/store', [CategoryController::class, 'store']);

    //VISUALIZAÇÃO

    //ROTAS DA Tag
    Route::get('/tag/create', [TagController::class, 'create']);
    Route::post('/tag/store', [TagController::class, 'store']);
    Route::get('/tag', [TagController::class, 'index']);


    //CARRINHO

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/store/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/decrement/{product}', [CartController::class, 'decrement'])->name('cart.decrement');
    Route::post('/cart/delete/{product}', [CartController::class, 'delete'])->name('cart.delete');
});
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/product', [ProductController::class, 'index']);
require __DIR__ . '/auth.php';

Route::get('/product/show/{product}', [ProductController::class, 'show']);




Route::get('two-factor', [TwoFactorController::class, 'show'])
    ->name('2fa.show');
Route::post('two-factor', [TwoFactorController::class, 'verify'])
    ->name('2fa.verify');
Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])
    ->name('2fa.resend');


