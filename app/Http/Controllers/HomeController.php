<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        
        $tagDestaque = Tag::where('name', 'index')->first();
        $destaques = $tagDestaque
            ? Product::where('tag_id', $tagDestaque->id)->with(['images', 'tag'])->get()
            : collect();

        $tagOferta = Tag::where('name', 'oferta')->first();
        $ofertas = $tagOferta
            ? Product::where('tag_id', $tagOferta->id)->with(['images', 'tag'])->take(4)->get()
            : collect();

        $categories = Category::all();

        // ← Carrinho para a sidebar
        $cart = auth()->check()
            ? \App\Models\Cart::with(['items.product.images'])
                ->firstOrCreate(['user_id' => auth()->id()])
            : new \App\Models\Cart();

        // Garante que items seja uma collection vazia se não autenticado
        if (!auth()->check()) {
            $cart->setRelation('items', collect());
        }

        return view('index', [
            'destaques' => $destaques,
            'ofertas' => $ofertas,
            'categories' => $categories,
            'cart' => $cart,
        ]);
    }
}