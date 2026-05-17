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

        return $this->cartResponse();
    }

    // Adiciona produto ao carrinho
    public function store(Request $request, Product $product)
    {
        if ($product->stock <= 0) {
            return $this->cartResponse('Produto fora de estoque.', false);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            if ($item->units >= $product->stock) {
                return $this->cartResponse('Estoque insuficiente.', false);
            }
            $item->increment('units');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'units'      => 1,
                'price'      => $product->price,
            ]);
        }

        return $this->cartResponse();
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

        return $this->cartResponse();
    }

    // Remove o item completamente
    public function delete(Product $product)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->items()->where('product_id', $product->id)->delete();
        }

        return $this->cartResponse();
    }

    // Retorna HTML da sidebar via AJAX
    public function sidebar()
    {
        $cart = Cart::with(['items.product.images'])
            ->firstOrCreate(['user_id' => auth()->id()]);

        return $this->cartResponse();
    }

    // Atualiza quantidade de um item
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['units' => 'required|integer|min:1']);

        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        if ($request->units > $cartItem->product->stock) {
            return $this->cartResponse('Estoque insuficiente.', false);
        }

        $cartItem->update(['units' => $request->units]);

        return $this->cartResponse();
    }

    // Helper — retorna JSON (AJAX) ou redirect (requisição normal)
    private function cartResponse(string $error = '', bool $success = true)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => $success,
                'error'   => $error,
            ]);
        }

        // Fallback para requisições normais (ex: cart/index)
        return $success
            ? redirect()->route('cart.index')
            : redirect()->back()->with('error', $error);
    }
}