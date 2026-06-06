<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
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
            'cart' => $cart,
            'total' => $total,
            'user' => auth()->user(),
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

        $total = $cart->items->sum(
            fn($i) => $i->units * $i->product->preco_com_desconto
        );

        // Cria pedido pendente
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'total' => $total,
        ]);

        foreach ($cart->items as $item) {

            $order->items()->create([
                'product_id' => $item->product_id,
                'units' => $item->units,
                'price' => $item->product->preco_com_desconto,
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($cart->items as $item) {

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval(
                        $item->product->preco_com_desconto * 100
                    ),
                ],
                'quantity' => $item->units,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',

            'success_url' =>
                url('/orders/success/' . $order->id),

            'cancel_url' =>
                url('/checkout'),

            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);

        return redirect($session->url);
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