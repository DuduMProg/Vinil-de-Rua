<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // Exibe a página do carrinho
    public function index()
    {
        $cart = Cart::with(['items.product.images'])
            ->firstOrCreate(['user_id' => auth()->id()]);

        return view('cart.index', ['cart' => $cart]);
    }

    // Adiciona produto ao carrinho
    public function store(Request $request, Product $product)
    {
        if ($product->stock <= 0) {
            return response()->noContent(422);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            if ($item->units >= $product->stock) {
                return response()->noContent(422);
            }
            $item->increment('units');
        } else {
            // CartController store()
            $cart->items()->create([
                'product_id' => $product->id,
                'units' => 1,
                'price' => $product->preco_com_desconto, // ← já aplica desconto
            ]);
        }

        return response()->noContent(); // 204
    }

    // Decrementa quantidade — se chegar a 0, remove o item
    public function decrement(Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->units <= 1 ? $item->delete() : $item->decrement('units');
        }

        return response()->noContent(); // 204
    }

    // Remove o item completamente
    public function delete(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->where('product_id', $product->id)->delete();
        }

        return response()->noContent(); // 204
    }

    // Atualiza quantidade manualmente
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['units' => 'required|integer|min:1']);

        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->units > $cartItem->product->stock) {
            return response()->noContent(422);
        }

        $cartItem->update(['units' => $request->units]);

        return response()->noContent(); // 204
    }

    // Retorna HTML da sidebar para o AJAX
    public function sidebar()
    {
        $cart = Cart::with(['items.product.images'])
            ->firstOrCreate(['user_id' => auth()->id()]);

        return view('cart.sidebar', ['cart' => $cart]);
    }
}