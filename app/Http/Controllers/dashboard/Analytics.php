<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;


class Analytics extends Controller
{
  public function index()
  {
    $totalUsers = User::count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('total_price');
    $totalProducts = Product::count();

    $today = Carbon::today();
    $latestOrders = Order::whereDate('created_at', $today) // Filter orders by today's date
    ->orderBy('created_at', 'desc') // Order by the latest created timestamp
    ->take(5) // Limit the results to 5
    ->get();

    return view('content.dashboard.dashboards-analytics', compact('totalUsers', 'totalOrders', 'totalRevenue', 'totalProducts', 'latestOrders'));
  }
}
