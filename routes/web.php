<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;



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

});
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/product', [ProductController::class, 'index']); 
require __DIR__ . '/auth.php';

Route::get('/product/show/{product}', [ProductController::class, 'show']);


