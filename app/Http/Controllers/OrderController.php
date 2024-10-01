<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('user')->get();
        return view('marketplace.orders', compact('orders'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', 1)->with('user')->get();
        return view('marketplace.myOrders', compact('orders'));
    }

    public function show($id)
    {
        $orders = Order::with(relations: 'orderItems.product')->with('user')->get();
        $order = Order::findOrFail($id); // This will throw a 404 if the product is not found

        // Return a view to display the product details, passing the product object
        return view('marketplace.order', compact('orders', 'order'));
    
    }

    public function showOwned($id)
    {
        $orders = Order::with(relations: 'orderItems.product')->with('user')->get();
        $order = Order::findOrFail($id); // This will throw a 404 if the product is not found

        // Return a view to display the product details, passing the product object
        return view('marketplace.myOrder', compact('orders', 'order'));
    
    }

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
            OrderItem::create(attributes: [
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            $product = Product::findOrFail($cartItem->product_id);
            $product->quantity -= $cartItem->quantity;

            // Ensure quantity does not go below zero
            if ($product->quantity < 0) {
                return response()->json(['error' => 'Insufficient product quantity for: ' . $product->name], 400);
            }

            // Save the updated product
            $product->save();
        }

        // Clear the cart
        $cart->delete();
        
        session()->flash('success', 'Ordered Successfully!');

        return redirect()->back(); 
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
    
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id); // This will throw a 404 if the product is not found
        $order->delete();

        session()->flash('success', 'Successfully Removed!');

        return redirect()->back(); 
    }
}
