<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
  public function index()
  {
    // Example statistics
    $totalUsers = User::count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('total_price'); // Assuming 'total' is a column in the Order model

    return view('admin.statistics.index', compact('totalUsers', 'totalOrders', 'totalRevenue'));
  }
}
