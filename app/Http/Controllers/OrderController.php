<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\LogService;
use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function __construct(StatisticService $statisticService,LogService $logService)
  {
    $this->middleware('role:admin')->only(['index', 'show', 'update', 'destroy']);
    $this->middleware('role:user')->only(['myOrders', 'showOwned', 'store']);
    $this->statisticService = $statisticService;
    $this->logService = $logService;
  }

  public function index()
  {
    $orders = Order::with('user')->get();
    return view('marketplace.orders', compact('orders'));
  }

  public function myOrders()
  {
    $orders = Order::where('user_id', Auth::user()->id)->with('user')->get();
    return view('marketplace.myOrders', compact('orders'));
  }

  public function show($id)
  {
    $orders = Order::with(relations: 'orderItems.product')->with('user')->get();
    $order = Order::findOrFail($id);

    return view('marketplace.order', compact('orders', 'order'));

  }

  public function showOwned($id)
  {
    $orders = Order::where('user_id', Auth::user()->id)->with(relations: 'orderItems.product')->with('user')->get();
    $order = Order::findOrFail($id);

    return view('marketplace.myOrder', compact('orders', 'order'));

  }

  public function store(Request $request)
  {
    $cart = Cart::with('cartItems.product')->where('user_id', Auth::user()->id)->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
      return response()->json(['error' => 'Your cart is empty'], 400);
    }

    $order = Order::create([
      'user_id' => Auth::user()->id,
      'total_price' => $cart->cartItems->sum(fn($item) => $item->product->price * $item->quantity),
      'status' => 'pending',
    ]);

    foreach ($cart->cartItems as $cartItem) {
      OrderItem::create(attributes: [
        'order_id' => $order->id,
        'product_id' => $cartItem->product_id,
        'quantity' => $cartItem->quantity,
        'price' => $cartItem->product->price,
      ]);

      $product = Product::findOrFail($cartItem->product_id);
      $product->quantity -= $cartItem->quantity;

      if ($product->quantity < 0) {
        return response()->json(['error' => 'Insufficient product quantity for: ' . $product->name], 400);
      }

      $product->save();
    }

    $cart->delete();

    session()->flash('success', 'Ordered Successfully!');

    // Update the total users statistic
    $this->statisticService->updateAllStatistics();

    // Log the "make_order" action
    $this->logService->logAction('make_order', 'Order created with ID: ' . $order->id);

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
    $order = Order::findOrFail($id);
    $order->delete();

    session()->flash('success', 'Successfully Removed!');

    return redirect()->back();
  }
}
