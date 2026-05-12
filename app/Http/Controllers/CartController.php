<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{

    // Exibe o carrinho do usuário
    public function index()
    {
        $cart = Cart::with(['items.product.images'])
            ->firstOrCreate(['user_id' => auth()->id()]);

        return view('cart.index', [
            'cart' => $cart,
        ]);
    }

    // Adiciona produto ao carrinho
    public function store(Request $request, Product $product)
    {
        // Verifica estoque
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Produto fora de estoque.');
        }

        // Busca ou cria o carrinho do usuário
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Verifica se o produto já está no carrinho
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            // Verifica se tem estoque suficiente para incrementar
            if ($item->units >= $product->stock) {
                return redirect()->back()->with('error', 'Estoque insuficiente.');
            }
            $item->increment('units');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'units'      => 1,
                'price'      => $product->price, // snapshot do preço atual
            ]);
        }

        return redirect()->route('cart.index');
    }

    // Atualiza quantidade de um item
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'units' => 'required|integer|min:1',
        ]);

        // Garante que o item pertence ao carrinho do usuário logado
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        // Verifica estoque
        if ($request->units > $cartItem->product->stock) {
            return redirect()->back()->with('error', 'Estoque insuficiente.');
        }

        $cartItem->update(['units' => $request->units]);

        return redirect()->route('cart.index')->with('success', 'Carrinho atualizado!');
    }

    // Decrementa quantidade — se chegar a 0, remove o item
    public function decrement(Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            if ($item->units <= 1) {
                $item->delete();
            } else {
                $item->decrement('units');
            }
        }

        return redirect()->route('cart.index');
    }

    // Remove o item completamente
    public function delete(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->where('product_id', $product->id)->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item removido!');
    }
}