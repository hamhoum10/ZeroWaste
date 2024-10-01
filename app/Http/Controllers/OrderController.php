<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::with('cartItems.product')->where('user_id', 1)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty'], 400);
        }

        // Create the order
        $order = Order::create([
            'user_id' => 1,
            'total_price' => $cart->cartItems->sum(fn($item) => $item->product->price * $item->quantity),
            'status' => 'pending',
        ]);

        // Create order items from cart items
        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        // Clear the cart
        $cart->delete();
        
        session()->flash('success', 'Ordered Successfully!');

        return redirect()->back(); 
    }
}
