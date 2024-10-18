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
        $cart = Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
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
        $cart = Cart::firstOrCreate(['user_id' => Auth::user()->id]);
        $cartItem->update(['quantity' => $request->quantity]);
        $totalPrice = CartItem::where('cart_id', $cart->id)
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->sum(DB::raw('cart_items.quantity * products.price'));

        $cart->total_price = $totalPrice;
        $cart->save();
        error_log( $cart->id);
        session()->flash('success', 'Successfully Updated!');

        return redirect()->back();
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        session()->flash('success', 'Successfully Removed!');

        return redirect()->back();
    }
}
