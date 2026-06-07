<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{


    // Lista todos os favoritos do usuário
    public function index()
    {
        $whishlists = Wishlist::with(['product.images'])
            ->where('user_id', auth()->id())
            ->get();

        return view('wishlist.index', [
            'whishlists' => $whishlists,
        ]);
    }

    // Adiciona ou remove favorito (toggle)
    public function store(Product $product)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            // Já está favoritado — remove
            $existing->delete();
        } else {
            // Não está — adiciona
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
        }

        // Redireciona de volta para a página anterior
        return redirect()->back();
    }

    // Remove favorito direto da página de favoritos
    public function delete(Product $product)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->route('whishlist.index');
    }

    public function sidebar()
    {
        $favorites = Wishlist::with(['product.images', 'product.tag'])
            ->where('user_id', auth()->id())
            ->get();

        return view('wishlist.sidebar', ['favorites' => $favorites]);
    }
}