<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Exibe a tela de checkout com os itens do carrinho
    public function index()
    {
        $cart = Cart::with(['items.product.images'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Seu carrinho está vazio.');
        }

        $total = $cart->items->sum(fn($i) => $i->units * $i->product->preco_com_desconto);

        return view('checkout.index', [
            'cart'  => $cart,
            'total' => $total,
            'user'  => auth()->user(),
        ]);
    }

    // Finaliza o pedido
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:pix,credit_card',
        ]);

        $cart = Cart::with(['items.product'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Seu carrinho está vazio.');
        }

        $total = $cart->items->sum(fn($i) => $i->units * $i->product->preco_com_desconto);

        // Cria o pedido
        $order = Order::create([
            'user_id'        => auth()->id(),
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'total'          => $total,
        ]);

        // Copia os itens do carrinho para o pedido
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'units'      => $item->units,
                'price'      => $item->product->preco_com_desconto,
            ]);

            // Decrementa o estoque
            $item->product->decrement('stock', $item->units);
        }

        // Limpa o carrinho
        $cart->items()->delete();

        return redirect('/orders/success/' . $order->id);
    }

    // Tela de confirmação do pedido
    public function success(Order $order)
    {
        // Garante que o pedido pertence ao usuário logado
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product.images');

        return view('checkout.success', ['order' => $order]);
    }
}