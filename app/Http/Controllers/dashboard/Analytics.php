<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index()
  {
    $totalUsers = User::count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('total_price'); // Assuming 'total' is a column in the Order model
    $totalProducts = Product::count();
    return view('content.dashboard.dashboards-analytics',compact('totalUsers','totalOrders','totalRevenue','totalProducts'));
  }
}
