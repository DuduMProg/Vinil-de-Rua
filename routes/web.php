<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/product', [ProductController::Class, 'index']);
Route::get('/product/create', [ProductController::Class, 'create']);
Route::post('/product/store', [ProductController::Class, 'store']);
Route::get('/product/edit/{product}', [ProductController::Class, 'edit']);
Route::post('/product/update/{product}', [ProductController::Class, 'update']);
Route::get('/product/delete/{product}', [ProductController::Class, 'delete']);


