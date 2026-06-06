<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Order;
use App\Models\Cart;

class StripeWebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header('Stripe-Signature');

        $secret = config('services.stripe.webhook_secret');

        try {

            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $secret
            );

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $orderId = $session->metadata->order_id;

            $order = Order::find($orderId);

            if ($order && $order->status === 'pending') {

                $order->update([
                    'status' => 'approved'
                ]);

                foreach ($order->items as $item) {

                    $item->product->decrement(
                        'stock',
                        $item->units
                    );
                }

                $cart = Cart::where(
                    'user_id',
                    $order->user_id
                )->first();

                if ($cart) {
                    $cart->items()->delete();
                }
            }
        }

        return response()->json([
            'success' => true
        ]);
    }
}