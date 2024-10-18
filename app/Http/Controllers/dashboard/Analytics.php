<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;


class Analytics extends Controller
{
  public function index()
  {
    // Fetch today's date
    $today = Carbon::today();

    // Fetch the pre-calculated daily statistics from the statistics table
    $totalUsers = Statistic::where('type', 'daily')->where('metric', 'total_users')->where('date', $today)->value('value');
    $totalOrders = Statistic::where('type', 'daily')->where('metric', 'total_orders')->where('date', $today)->value('value');
    $totalRevenue = Statistic::where('type', 'daily')->where('metric', 'total_revenue')->where('date', $today)->value('value');
    $totalProducts = Statistic::where('type', 'daily')->where('metric', 'total_products')->where('date', $today)->value('value');

    // Get the latest 5 orders for today
    $latestOrders = Order::orderBy('created_at', 'desc')
      ->take(6)
      ->get();


    // Return the view with the fetched data
    return view('content.dashboard.dashboards-analytics', compact('totalUsers', 'totalOrders', 'totalRevenue', 'totalProducts', 'latestOrders'));
  }
}
