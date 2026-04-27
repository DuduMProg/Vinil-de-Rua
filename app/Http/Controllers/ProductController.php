<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('product.index', [
            'products' => Product::withCount('images')->get()
        ]);
    }

    public function create(){
        return view('product.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'nullable|url'
        ]);

        // cria produto (sem imagens)
        $product = Product::create($request->only([
            'name','description','price'
        ]));

        // salva imagens (links)
        if ($request->images) {
            foreach ($request->images as $img) {
                if (!empty($img)) {
                    $product->images()->create([
                        'path' => $img
                    ]);
                }
            }
        }

        return redirect('/product');
    }

    public function edit(Product $product){
        // carrega imagens junto
        $product->load('images');

        return view('product.edit', [
            'product'=>$product
        ]);
    }

    public function update(Request $request, Product $product){

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'nullable|url'
        ]);

        // atualiza dados do produto
        $product->update($request->only([
            'name','description','price'
        ]));

        // adiciona novas imagens
        if ($request->images) {
            foreach ($request->images as $img) {
                if (!empty($img)) {
                    $product->images()->create([
                        'path' => $img
                    ]);
                }
            }
        }

        return redirect('/product');
    }

    public function delete(Product $product){
        $product->delete(); // cascade apaga imagens
        return redirect('/product');
    }
}