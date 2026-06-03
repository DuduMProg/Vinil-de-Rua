<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products'   => Product::with(['images', 'category', 'tag'])->withCount('images')->get(),
            'categories' => Category::withCount('products')->get()
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'tags'       => Tag::all()
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
            'tag_id'      => 'nullable|exists:tag,id',
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
            'tag_id'      => $request->tag_id,
            'stock'       => $request->stock ?? 0,
        ]);

        if ($request->filled('main_img')) {
            $product->images()->create([
                'path'     => $request->main_img,
                'is_cover' => true,
            ]);
        }

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
        $product->load('images');

        return view('admin.products.edit', [
            'product'    => $product,
            'categories' => Category::all(),
            'tags'       => Tag::all()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update([
            'name'        => $request->name,
            'artist'      => $request->artist,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'tag_id'      => $request->tag_id,
            'stock'       => $request->stock ?? $product->stock,
        ]);

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

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();
        return redirect('/product')->with('success', 'Produto deletado com sucesso!');
    }

    // show é público — mantém na pasta product
    public function show($id)
    {
        $product = Product::with(['images', 'category', 'tag'])->findOrFail($id);
        return view('product.show', compact('product'));
    }
}