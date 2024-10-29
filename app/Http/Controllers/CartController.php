<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only([]);
        $this->middleware('role:user')->only(['index', 'store', 'update', 'destroy']);
    }

    public function index()
    {
        $cart = Cart::with('cartItems.product')->where('user_id', Auth::user()->id)->first();
        return view('marketplace.cart', compact('cart'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $validatedData = $request->validate([
            'quantity.' . $request->product_id => 'required|integer|min:1|max:' . $product->quantity
        ], [
            'quantity.' . $request->product_id . '.required' => 'The quantity field is required.',
            'quantity.' . $request->product_id . '.integer' => 'The quantity must be an integer.',
            'quantity.' . $request->product_id . '.min' => 'The quantity must be at least 1.',
            'quantity.' . $request->product_id . '.max' => 'The quantity must not be greater than ' . $product->quantity . '.',
        ]);


        $quantity = $validatedData['quantity'][$product->id];

        $cart = Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['quantity' => $quantity]
        );
        $totalPrice = CartItem::where('cart_id', $cart->id)
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->sum(DB::raw('cart_items.quantity * products.price'));

        $cart->total_price = $totalPrice;
        $cart->save();

        session()->flash('success', 'Successfully Added!');

        return redirect()->back();
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->quantity
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        $cartItem->update(['quantity' => $request->quantity]);
        $totalPrice = CartItem::where('cart_id', $cart->id)
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->sum(DB::raw('cart_items.quantity * products.price'));

        $cart->total_price = $totalPrice;
        $cart->save();
        session()->flash('success', 'Successfully Updated!');

        return redirect()->back();
    }

    public function destroy(CartItem $cartItem)
    {
        $cartId = $cartItem->cart_id;

        $cartItem->delete();
        $totalPrice = CartItem::where('cart_id', $cartId)
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->sum(DB::raw('cart_items.quantity * products.price'));

        $cart = Cart::find($cartId);
        $cart->total_price = $totalPrice;
        $cart->save();

        session()->flash('success', 'Successfully Removed!');

        return redirect()->back();
    }
}
