<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'products' => Product::withCount('images')->get()
        ]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'nullable|url'
        ]);

        // cria produto (sem imagens)
        $product = Product::create($request->only([
            'name',
            'description',
            'price',
            'category_id'
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

    public function edit(Product $product)
    {
        // carrega imagens junto
        $product->load('images');

        return view('product.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'nullable|url'
        ]);

        // atualiza produto
        $product->update($request->only([
            'name',
            'description',
            'price'
        ]));

        // 🔄 substitui imagens (remove antigas + adiciona novas)
        if ($request->images && count(array_filter($request->images)) > 0) {

            $product->images()->delete();

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

    public function delete(Product $product)
    {
        $product->delete();
        return redirect('/product');
    }

    public function show(Product $product){
        return view('product.show', ['product'=>$product]);
    }
}