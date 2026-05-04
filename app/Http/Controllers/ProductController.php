<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'products' => Product::with(['images', 'category'])->withCount('images')->get()
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'artist'      => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'nullable|integer|min:0',
            'main_img'    => 'nullable|url',
            'images.*'    => 'nullable|url',
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'artist'      => $request->artist,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'stock'       => $request->stock ?? 0,
        ]);

        // Salva imagem principal como primeira (is_cover = true)
        if ($request->filled('main_img')) {
            $product->images()->create([
                'path'     => $request->main_img,
                'is_cover' => true,
            ]);
        }

        // Salva imagens secundárias
        if ($request->images) {
            foreach ($request->images as $img) {
                if (!empty($img)) {
                    $product->images()->create([
                        'path'     => $img,
                        'is_cover' => false,
                    ]);
                }
            }
        }

        return redirect('/product')->with('success', 'Produto criado com sucesso!');
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
            'name'        => 'required|string|max:255',
            'artist'      => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'nullable|integer|min:0',
            'main_img'    => 'nullable|url',
            'images.*'    => 'nullable|url',
        ]);

        $product->update([
            'name'        => $request->name,
            'artist'      => $request->artist,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'stock'       => $request->stock ?? $product->stock,
        ]);

        // Substitui imagens se novas forem enviadas
        $novas = array_filter(array_merge(
            [$request->main_img],
            $request->images ?? []
        ));

        if (count($novas) > 0) {
            $product->images()->delete();

            foreach ($novas as $index => $img) {
                $product->images()->create([
                    'path'     => $img,
                    'is_cover' => $index === 0,
                ]);
            }
        }

        return redirect('/product')->with('success', 'Produto atualizado com sucesso!');
    }

    // ✅ DELETE corrigido — usa método DELETE via form, não GET via link
    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();

        return redirect('/product')->with('success', 'Produto deletado com sucesso!');
    }

    public function show(Product $product)
    {
        $product->load(['images', 'category']);

        return view('product.show', ['product' => $product]);
    }
}