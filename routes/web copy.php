<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/product', [ProductController::Class, 'index']);
Route::get('/product/create', [ProductController::Class, 'create']);
Route::post('/product/store', [ProductController::Class, 'store']);
Route::get('/product/edit/{product}', [ProductController::Class, 'edit']);
Route::post('/product/update/{product}', [ProductController::Class, 'update']);
Route::get('/product/delete/{product}', [ProductController::Class, 'delete']);


//Categoria
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/create', [CategoryController::class, 'create']);
Route::post('/category/store', [CategoryController::class, 'store']);
