<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('product.index', ['products' => Product::all()]);
    }

    public function create(){
        return view('product.create');
    }

    public function store(Request $request){
        Product::create($request->all());
        return redirect('/product');
    }

    public function edit(Product $product){
        return view('product.edit', ['product'=>$product]);
    }

    public function update(Request $request, Product $product){
        $product->update($request->all());
        return redirect('/product');
    }

    public function delete(Product $product){
        $product->delete();
        return redirect('/product');
    }
}
